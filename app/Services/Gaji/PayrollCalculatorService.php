<?php

namespace App\Services\Gaji;

use App\Models\Absensi\Absensi;
use App\Models\Absensi\Lembur;
use App\Models\Absensi\Cuti;
use App\Models\Absensi\Izin;
use App\Models\Gaji\GajiDetail;
use App\Models\Gaji\GajiJabatan;
use App\Models\Gaji\GajiPeriode;
use App\Models\Gaji\GajiTrx;
use App\Models\Gaji\KomponenGaji;
use App\Models\Gaji\TarifLembur;
use App\Models\Gaji\TarifPotongan;
use App\Models\Gaji\GajiUmum;
use App\Models\sdm\Sdm;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

class PayrollCalculatorService
{
    public function calculate(Sdm $sdm, GajiPeriode $periode)
    {
        return DB::transaction(function () use ($sdm, $periode) {
            Log::info("PayrollCalc: Starting for SDM {$sdm->id} - Period {$periode->periode_id}");

            $trx = GajiTrx::firstOrNew([
                'periode_id' => $periode->periode_id,
                'sdm_id'     => $sdm->id,
            ]);

            if (!$trx->exists) $trx->transaksi_id = $trx->transaksi_id ?? (string) Str::uuid();
            $trx->save();

            GajiDetail::where('transaksi_id', $trx->transaksi_id)->delete();

            $totalPendapatan = 0;
            $totalPotongan   = 0;

            // 1. Gaji Jabatan (Fixed Components)
            $struktural = \App\Models\sdm\SdmStruktural::where('id_sdm', $sdm->id)
                ->where('tanggal_mulai_menjabat', '<=', $periode->tanggal_selesai)
                ->orderBy('tanggal_mulai_menjabat', 'desc')
                ->first();

            if ($struktural && $struktural->id_jabatan) {
                $comps = GajiJabatan::with('komponen')
                    ->where('id_jabatan', $struktural->id_jabatan)
                    ->get();

                foreach ($comps as $comp) {
                    if (!$comp->komponen) continue;
                    $nominal = $comp->use_override ? $comp->override_nominal : $this->getComponentNominal($comp->komponen);
                    if ($nominal > 0) {
                        $this->createDetail($trx->transaksi_id, $comp->komponen_id, $nominal, 'Jabatan: ' . $comp->komponen->nama_komponen, 'Master Gaji Jabatan');
                        if ($this->isIncome($comp->komponen)) $totalPendapatan += $nominal;
                        else $totalPotongan += $nominal;
                    }
                }
            }

            // 2. Potongan Terlambat
            $lateInfo = $this->calculateLateDeduction($sdm, $periode);
            if ($lateInfo['amount'] > 0) {
                $this->createDetail($trx->transaksi_id, $lateInfo['komponen_id'], $lateInfo['amount'], $lateInfo['description'], 'Absensi');
                $totalPotongan += $lateInfo['amount'];
            }

            // 3. Lembur
            $overtimeInfo = $this->calculateOvertime($sdm, $periode);
            if ($overtimeInfo['amount'] > 0) {
                $this->createDetail($trx->transaksi_id, $overtimeInfo['komponen_id'], $overtimeInfo['amount'], $overtimeInfo['description'], 'Lembur');
                $totalPendapatan += $overtimeInfo['amount'];
            }

            // 4. Absent Deductions (Alpha, Sakit if dynamic)
            $absentDeductions = $this->calculateAbsentDeductions($sdm, $periode);
            foreach ($absentDeductions as $info) {
                if ($info['amount'] > 0) {
                    $this->createDetail($trx->transaksi_id, $info['komponen_id'], $info['amount'], $info['description'], 'Absensi');
                    $totalPotongan += $info['amount'];
                }
            }

            $nett = max(0, $totalPendapatan - $totalPotongan);
            $trx->update([
                'total_penghasil' => $totalPendapatan,
                'total_potongan'  => $totalPotongan,
                'total_dibayar'   => $nett
            ]);

            return $trx;
        });
    }

    private function isIncome($komponen)
    {
        $jenis = Str::upper($komponen->jenis);
        return in_array($jenis, ['PENGHASIL', 'PENERIMAAN', 'PENDAPATAN', 'PENGHASILAN']);
    }

    private function getComponentNominal($komponen)
    {
        if (!$komponen) return 0;
        if ($komponen->aturan_nominal === 'gaji_umum') {
            $umum = GajiUmum::where('umum_id', $komponen->referensi_id)->first();
            return $umum ? $umum->nominal : 0;
        }
        if ($komponen->aturan_nominal === 'tarif_potongan') {
            $tarif = TarifPotongan::where('potongan_id', $komponen->referensi_id)->first();
            return $tarif ? $tarif->tarif_per_kejadian : 0;
        }
        return $komponen->nominal_default ?? 0;
    }

    private function calculateLateDeduction($sdm, $periode)
    {
        $attendance = Absensi::where('sdm_id', $sdm->id)
            ->whereBetween('tanggal', [$periode->tanggal_mulai, $periode->tanggal_selesai])
            ->where(function($q) {
                $q->where('jenis_absen_id', 'JAI-004') // JAI-004 is TERLAMBAT
                  ->orWhere('total_terlambat', '>', 0);
            })
            ->count();

        if ($attendance <= 0) return ['amount' => 0];

        // Search for late deduction component
        $komponen = KomponenGaji::on('gaji')
            ->where(function($q) {
                $q->where('nama_komponen', 'like', '%Absensi%')
            ->orWhere('nama_komponen', 'like', '%Telat%')
                  ->orWhere('nama_komponen', 'like', '%Terlambat%');
            })
            ->where('jenis', 'POTONGAN')
            ->first();

        if (!$komponen) return ['amount' => 0];

        $rate = $this->getComponentNominal($komponen);

        return [
            'amount' => $attendance * $rate,
            'komponen_id' => $komponen->komponen_id,
            'description' => "Potongan Terlambat ($attendance hari x Rp " . number_format($rate) . ")"
        ];
    }

    private function calculateOvertime($sdm, $periode)
    {
        if (!Schema::connection('att')->hasTable('lembur')) return ['amount' => 0];

        $lemburs = Lembur::where('sdm_id', $sdm->id)
            ->whereBetween('tanggal', [$periode->tanggal_mulai, $periode->tanggal_selesai])
            ->where('status', 'DISETUJUI')
            ->get();

        $totalHours = $lemburs->sum('durasi_jam');
        if ($totalHours <= 0) return ['amount' => 0];

        $komponen = KomponenGaji::where('nama_komponen', 'like', '%Lembur%')->first();
        $tarif = TarifLembur::orderBy('berlaku_mulai', 'desc')->first();
        $rate = $tarif ? $tarif->tarif_per_jam : 0;

        return [
            'amount' => $totalHours * $rate,
            'komponen_id' => $komponen ? $komponen->komponen_id : 'LEMBUR',
            'description' => "Lembur (" . floatval($totalHours) . " jam x Rp " . number_format($rate) . ")"
        ];
    }

    private function calculateAbsentDeductions($sdm, $periode)
    {
        $deductions = [];

        // 1. Alpha/Sakit from Absensi
        $absences = Absensi::where('sdm_id', $sdm->id)
            ->whereBetween('tanggal', [$periode->tanggal_mulai, $periode->tanggal_selesai])
            ->whereIn('jenis_absen_id', ['JAI-002', 'JAI-005']) // JAI-002: SAKIT
            ->get();

        if ($absences->count() > 0) {
            $komponen = KomponenGaji::where('nama_komponen', 'like', '%Sakit%')
                ->orWhere('nama_komponen', 'like', '%Alpha%')
                ->first();
            $rate = $this->getComponentNominal($komponen);
            $deductions[] = [
                'amount' => $absences->count() * $rate,
                'komponen_id' => $komponen ? $komponen->komponen_id : 'ABSENT',
                'description' => "Potongan Absen (" . $absences->count() . " hari x Rp " . number_format($rate) . ")"
            ];
        }

        return $deductions;
    }

    private function createDetail($trxId, $komponenId, $nominal, $keterangan, $sumber)
    {
        GajiDetail::create([
            'transaksi_id'   => $trxId,
            'komponen_id'    => $komponenId,
            'nominal'        => $nominal,
            'keterangan'     => $keterangan,
            'sumber_nominal' => $sumber
        ]);
    }
}
