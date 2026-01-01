<?php

namespace App\Services\Gaji;

use App\Models\Absensi\Absensi;
use App\Models\Absensi\Cuti;
use App\Models\Absensi\Izin;
use App\Models\Absensi\Lembur;
use App\Models\Gaji\GajiTrx;
use App\Models\Gaji\GajiDetail;
use App\Models\Gaji\GajiJabatan;
use App\Models\Gaji\GajiPeriode;
use App\Models\Gaji\GajiUmum;
use App\Models\Gaji\KomponenGaji;
use App\Models\Gaji\TarifPotongan;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PayrollManualProcessorService
{
    /**
     * Proses payroll satu pegawai
     */
    public function processSingleEmployee(string $periodeId, string $sdmId): GajiTrx
    {
        DB::connection('gaji')->beginTransaction();

        try {
            /** =========================
             *  1. Ambil Data Periode
             * ========================= */
            $periode = GajiPeriode::on('gaji')->findOrFail($periodeId);


            /** =========================
             *  2. Ambil Data Pegawai
             * ========================= */
            $pegawai = DB::connection('mysql')
                ->table('sdm')
                ->leftJoin('sdm_struktural', function($join) {
                    $join->on('sdm.id', '=', 'sdm_struktural.id_sdm')
                         ->whereNull('sdm_struktural.file_sk_keluar');
                })
                ->leftJoin('person', 'person.id', '=', 'sdm.id_person')
                ->leftJoin('master_unit', 'master_unit.id_unit', '=', 'sdm_struktural.id_unit')
                ->leftJoin('master_jabatan', 'master_jabatan.id_jabatan', '=', 'sdm_struktural.id_jabatan')
                ->select([
                    'sdm_struktural.id_struktural',
                    'sdm.id as id_sdm',
                    'sdm_struktural.id_unit',
                    'sdm_struktural.id_jabatan',
                    'person.nama_lengkap',
                    'person.nik',
                    'master_unit.unit as nama_unit',
                    'master_jabatan.jabatan as nama_jabatan',
                    'sdm.nip',
                    'sdm.status_pegawai',
                ])
                ->where('sdm.id', $sdmId)
                ->first();

            if (!$pegawai) {
                throw new \Exception("Data SDM dengan ID {$sdmId} tidak ditemukan di master data (tabel sdm)");
            }

            if (!$pegawai->id_jabatan) {
                throw new \Exception("Pegawai {$pegawai->nama_lengkap} (ID: {$sdmId}) tidak memiliki data jabatan/unit kerja aktif di sdm_struktural");
            }



            /** =========================
             *  3. Buat Header Transaksi
             * ========================= */
            $transaksiId = $this->generateTransactionId();

            $gajiTrx = GajiTrx::on('gaji')->create([
                'transaksi_id'       => $transaksiId,
                'periode_id'         => $periode->periode_id,
                'sdm_id'             => $sdmId,
                'total_penghasil'    => 0,
                'total_potongan'     => 0,
                'total_dibayar'      => 0,
            ]);

            $totalPenghasilan = 0;
            $totalPotongan = 0;

            /** =========================
             *  4. Ambil Komponen Gaji
             * ========================= */
            $komponenList = $this->getEmployeeComponents($pegawai->id_jabatan);

            foreach ($komponenList as $komponen) {
                if (!$komponen) continue;

                $nominal = $this->calculateNominal($komponen, $pegawai->id_jabatan);
                $qtyData = $this->calculateQuantityData($komponen, $sdmId, $periode);
                $jumlah  = $qtyData['qty'];
                $desc    = $qtyData['desc'];

                $subtotal = $nominal * $jumlah;

                if ($subtotal == 0 && $jumlah == 0) continue;

                /** =========================
                 *  5. Insert Detail
                 * ========================= */
                GajiDetail::on('gaji')->create([
                    'transaksi_id'     => $transaksiId,
                    'komponen_id'      => $komponen->komponen_id,
                    'nominal'          => $subtotal,
                    'sumber_nominal'   => $komponen->aturan_nominal ?? 'manual',
                    'referensi_id'     => $komponen->referensi_id,
                    'keterangan'       => $desc . ($jumlah > 1 ? " (" . floatval($jumlah) . " x " . number_format($nominal) . ")" : ""),
                ]);

                if (in_array(strtoupper($komponen->jenis), ['PENERIMAAN', 'PENGHASIL', 'PENGHASILAN', 'PENDAPATAN'])) {
                    $totalPenghasilan += $subtotal;
                } else {
                    $totalPotongan += $subtotal;
                }
            }

            /** =========================
             *  6. Update Total Header
             * ========================= */
            $gajiTrx->update([
                'total_penghasil' => $totalPenghasilan,
                'total_potongan'    => $totalPotongan,
                'total_dibayar'     => $totalPenghasilan - $totalPotongan,
            ]);

            DB::connection('gaji')->commit();

            return $gajiTrx->fresh('details');

        } catch (\Exception $e) {
            DB::connection('gaji')->rollBack();

            Log::error('Gagal proses payroll manual', [
                'periode_id' => $periodeId,
                'sdm_id'     => $sdmId,
                'error'      => $e->getMessage(),
            ]);

            throw $e;
        }
    }


    /** =========================
     *  TRANSACTION ID
     * ========================= */
    private function generateTransactionId(): string
    {
        $prefix = 'PAY-' . date('ym'); // Example: PAY-2512

        $last = GajiTrx::on('gaji')
            ->where('transaksi_id', 'like', 'PAY-%')
            ->orderByRaw('CAST(SUBSTRING(transaksi_id, 5) AS UNSIGNED) DESC')
            ->first();

        $lastId = $last ? $last->transaksi_id : 'PAY-0000';
        $num = intval(substr($lastId, 4)) + 1;

        $newId = 'PAY-' . str_pad($num, 4, '0', STR_PAD_LEFT);

        // Final guard against duplicates
        while (GajiTrx::on('gaji')->where('transaksi_id', $newId)->exists()) {
            $num++;
            $newId = 'PAY-' . str_pad($num, 4, '0', STR_PAD_LEFT);
        }

        return $newId;
    }

    /** =========================
     *  KOMPONEN GAJI
     * ========================= */
    private function getEmployeeComponents(string $jabatanId)
    {
        $komponenJabatan = GajiJabatan::with('komponen')
            ->where('id_jabatan', $jabatanId)
            ->get()
            ->pluck('komponen')
            ->filter();

        $komponenUmum = KomponenGaji::where('is_umum', true)
            ->get();

        $all = $komponenJabatan->merge($komponenUmum);

        // Autodiscover attendance components if missing
        $keywords = ['Lembur', 'Telat', 'Terlambat', 'Izin', 'Cuti', 'Absensi', 'Alpha', 'Sakit'];
        $currentNames = $all->pluck('nama_komponen')->map(fn($n) => strtolower($n));

        foreach ($keywords as $kw) {
            $found = false;
            foreach ($currentNames as $cn) {
                if (str_contains($cn, strtolower($kw))) {
                    $found = true;
                    break;
                }
            }

            if (!$found) {
                $comp = KomponenGaji::on('gaji')->where('nama_komponen', 'like', "%$kw%")->first();
                if ($comp) {
                    $all->push($comp);
                    $currentNames->push(strtolower($comp->nama_komponen));
                }
            }
        }

        return $all->unique('komponen_id');
    }

    /** =========================
     *  NOMINAL
     * ========================= */
    private function calculateNominal($komponen, string $jabatanId): float
    {
        $gajiJabatan = GajiJabatan::where('id_jabatan', $jabatanId)
            ->where('komponen_id', $komponen->komponen_id)
            ->first();

        if ($gajiJabatan && $gajiJabatan->use_override && $gajiJabatan->override_nominal !== null) {
            return (float) $gajiJabatan->override_nominal;
        }

        switch ($komponen->aturan_nominal ?? 'manual') {
            case 'gaji_umum':
                return $this->getNominalFromGajiUmum($komponen->referensi_id, $komponen->komponen_id);

            case 'tarif_potongan':
                return $this->getNominalFromTarifPotongan($komponen->referensi_id, $komponen->komponen_id);

            case 'tarif_lembur':
                return $this->getNominalFromTarifLembur();

            default:
                return (float) ($komponen->nominal_default ?? 0);
        }
    }

    private function getNominalFromGajiUmum($refId, $komponenId = null): float
    {
        $refId = trim($refId);
        $m = GajiUmum::on('gaji')->where('id', $refId)
            ->orWhere('umum_id', $refId)
            ->first();

        return $m ? (float) $m->nominal : 0;
    }

    private function getNominalFromTarifPotongan($refId, $komponenId = null): float
    {
        $refId = trim($refId);
        $komponenId = trim($komponenId);

        $q = TarifPotongan::on('gaji')->where('id', $refId)
            ->orWhere('potongan_id', $refId);

        if ($komponenId) {
            $q->orWhere('komponen_id', $komponenId);
        }

        $m = $q->first();
        return $m ? (float) $m->tarif_per_kejadian : 0;
    }

    private function getNominalFromTarifLembur(): float
    {
        // Ambil tarif lembur terbaru yang aktif
        $m = \App\Models\Gaji\TarifLembur::orderBy('berlaku_mulai', 'desc')->first();
        return $m ? (float) $m->tarif_per_jam : 0;
    }

    /** =========================
     *  QUANTITY
     * ========================= */
    private function calculateQuantityData($komponen, string $sdmId, $periode): array
    {
        $name = strtolower($komponen->nama_komponen ?? '');
        $qty = 1.0;
        $desc = "Auto - {$komponen->nama_komponen}";

        if (str_contains($name, 'lembur')) {
            $qty = $this->getJamLembur($sdmId, $periode);
            $desc = "Lembur ($qty jam)";
        } elseif (str_contains($name, 'absen') || str_contains($name, 'telat') || str_contains($name, 'terlambat')) {
            $qty = $this->getHariTerlambat($sdmId, $periode);
            $desc = "Potongan Terlambat ($qty hari)";
        } elseif (str_contains($name, 'izin')) {
            $qty = $this->getJamIzin($sdmId, $periode);
            $desc = "Potongan Izin ($qty jam)";
        } elseif (str_contains($name, 'cuti')) {
            $qty = $this->getHariCuti($sdmId, $periode);
            $desc = "Potongan Cuti ($qty hari)";
        } elseif (str_contains($name, 'absen')) {
            $qty = $this->getHariAbsen($sdmId, $periode);
            $desc = "Potongan Absen ($qty hari)";
        } elseif (str_contains($name, 'makan') || str_contains($name, 'transport') || str_contains($name, 'harian') || str_contains($name, 'hadir')) {
            $qty = $this->getHariKerja($sdmId, $periode);
            $desc = "Tunjangan Harian ($qty hari)";
        }

        return ['qty' => (float)$qty, 'desc' => $desc];
    }

    private function getJamLembur($sdmId, $periode): float
    {
        return (float) Lembur::where('sdm_id', $sdmId)
            ->where('status', 'DISETUJUI')
            ->whereBetween('tanggal', [$periode->tanggal_mulai, $periode->tanggal_selesai])
            ->sum('durasi_jam');
    }

    private function getHariTerlambat($sdmId, $periode): float
    {
        return (float) Absensi::where('sdm_id', $sdmId)
            ->whereBetween('tanggal', [$periode->tanggal_mulai, $periode->tanggal_selesai])
            ->where(function($q) {
                $q->where('jenis_absen_id', 'JAI-004') // JAI-004: TERLAMBAT
                  ->orWhere('total_terlambat', '>', 0);
            })
            ->count();
    }

    private function getJamIzin($sdmId, $periode): float
    {
        $total = 0;

        Izin::where('sdm_id', $sdmId)
            ->where('status', 'DISETUJUI')
            ->whereBetween('tanggal', [$periode->tanggal_mulai, $periode->tanggal_selesai])
            ->get()
            ->each(function ($izin) use (&$total) {
                if ($izin->jam_mulai && $izin->jam_selesai) {
                    $mulai = Carbon::parse($izin->jam_mulai);
                    $selesai = Carbon::parse($izin->jam_selesai);
                    $total += $selesai->diffInMinutes($mulai) / 60;
                } else {
                    $total += 8; // Default 8 jam
                }
            });

        return (float) $total;
    }

    private function getHariCuti($sdmId, $periode): float
    {
        $total = Cuti::where('sdm_id', $sdmId)
            ->where('status', 'DISETUJUI')
            ->whereBetween('tanggal_mulai', [$periode->tanggal_mulai, $periode->tanggal_selesai])
            ->sum('total_hari');

        return (float) $total;
    }

    private function getHariKerja($sdmId, $periode): float
    {
        return (float) Absensi::where('sdm_id', $sdmId)
            ->whereBetween('tanggal', [$periode->tanggal_mulai, $periode->tanggal_selesai])
            ->whereIn('jenis_absen_id', ['JAI-001', 'JAI-004']) // HADIR, TERLAMBAT
            ->count();
    }

    private function getHariAbsen($sdmId, $periode): float
    {
        return (float) Absensi::where('sdm_id', $sdmId)
            ->whereBetween('tanggal', [$periode->tanggal_mulai, $periode->tanggal_selesai])
            ->whereIn('jenis_absen_id', ['JAI-002', 'JAI-005']) // SAKIT, ALPHA
            ->count();
    }
}
