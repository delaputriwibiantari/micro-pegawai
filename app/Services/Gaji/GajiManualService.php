<?php

namespace App\Services\Gaji;

use App\Models\Gaji\GajiDetail;
use App\Models\Gaji\GajiTrx;
use App\Models\Gaji\KomponenGaji;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

final class GajiManualService
{

    public function __construct()
    {
    }

    /* ============================================================
     * GET DATA
     * ============================================================
     */

    public function getListData(Request $request): Collection
    {
        // ambil data gaji dari DB koneksi gaji
        $data = GajiTrx::on('gaji')
            ->leftJoin('gaji_periode', 'gaji_periode.periode_id', '=', 'gaji_trx.periode_id')
            ->select([
                'gaji_trx.*',
                'gaji_periode.tahun',
                'gaji_periode.status',
                DB::raw('DATE_FORMAT(gaji_periode.tanggal_mulai, "%M - %Y") as bulan'),
            ])
            ->when($request->query('periode_id'), fn($q,$v) => $q->where('gaji_trx.periode_id', $v))
            ->orderBy('gaji_trx.transaksi_id', 'desc')
            ->get();

        // Ambil daftar SDM dari DB koneksi mysql
        $sdmData = DB::connection('mysql')
            ->table('sdm')
            ->leftJoin('person', 'person.id', '=', 'sdm.id_person')
            ->leftJoin('sdm_struktural', 'sdm_struktural.id_sdm', '=', 'sdm.id')
            ->leftJoin('master_unit', 'master_unit.id_unit', '=', 'sdm_struktural.id_unit')
            ->leftJoin('master_jabatan', 'master_jabatan.id_jabatan', '=', 'sdm_struktural.id_jabatan')
            ->select([
                'sdm.id',
                'person.nama_lengkap',
                'sdm_struktural.id_unit',
                'sdm_struktural.id_jabatan',
                'master_unit.unit as unit_kerja',
                'master_jabatan.jabatan',
            ])
            ->get()
            ->keyBy('id'); // Index berdasarkan sdm.id

        // Mapping manual data SDM
        foreach ($data as $row) {
            $sdm = $sdmData[$row->sdm_id] ?? null;

            $row->nama_lengkap  = $sdm->nama_lengkap ?? null;
            $row->id_unit   = $sdm->id_unit ?? null;
            $row->id_jabatan = $sdm->id_jabatan ?? null;
            $row->unit_kerja      = $sdm->unit_kerja     ?? null;
            $row->jabatan   = $sdm->jabatan ?? null;
        }

        return $data;
    }




    public function getDetailTransaksi(string $trxId): ?GajiTrx
    {
        return GajiTrx::query()
            ->leftJoin('sdm', 'sdm.id', '=', 'gaji_trx.sdm_id')
            ->leftJoin('gaji_periode', 'gaji_periode.periode_id', '=', 'gaji_trx.periode_id')
            ->select([
                'gaji_trx.*',
                'sdm.nama_lengkap',
                'gaji_periode.tahun',
                'gaji_periode.tanggal_mulai',
                'gaji_periode.tanggal_selesai',
            ])
            ->where('gaji_trx.transaksi_id', $trxId)
            ->first();
    }

    public function getDetailKomponen(string $trxId): Collection
    {
        return GajiDetail::query()
            ->leftJoin('komponen_gaji', 'komponen_gaji.komponen_id', '=', 'gaji_detail.komponen_id')
            ->select([
                'gaji_detail.*',
                'komponen_gaji.nama_komponen',
                'komponen_gaji.jenis',
                'komponen_gaji.is_umum',
            ])
            ->where('gaji_detail.transaksi_id', $trxId)
            ->orderBy('gaji_detail.komponen_id')
            ->get();
    }

    /* ============================================================
     * CREATE
     * ============================================================
     */

    public function create(array $data): GajiTrx
    {
        return GajiTrx::create($data);
    }

    public function createDetail(array $data): GajiDetail
    {
        return GajiDetail::create($data);
    }

    /* ============================================================
     * UPDATE
     * ============================================================
     */

    public function update(GajiTrx $trx, array $data): GajiTrx
    {
        $trx->update($data);
        return $trx;
    }

    public function updateDetail(GajiDetail $detail, array $data): GajiDetail
    {
        $detail->update($data);
        return $detail;
    }

    /* ============================================================
     * DELETE
     * ============================================================
     */

    public function deleteTransaksi(GajiTrx $trx): void
    {
        // hapus detail terlebih dahulu
        GajiDetail::where('transaksi_id', $trx->transaksi_id)->delete();
        $trx->delete();
    }

    public function deleteDetail(GajiDetail $detail): void
    {
        $detail->delete();
    }

    /* ============================================================
     * UTIL / HELPER
     * ============================================================
     */

    public function getKomponenGaji(): Collection
    {
        return KomponenGaji::orderBy('nama_komponen')->get();
    }

    public function findTrxById(string $id): ?GajiTrx
    {
        return GajiTrx::find($id);
    }

    public function findDetailById(string $id): ?GajiDetail
    {
        return GajiDetail::find($id);
    }

    public function prosesPayroll(array $data)
    {
        return DB::transaction(function () use ($data) {

            // ============================
            // 1. SIMPAN HEADER gaji_trx
            // ============================
            $trx = GajiTrx::create([
                'periode_id'        => $data['periode_id'],
                'sdm_id'            => $data['sdm_id'],
                'total_penghasilan' => 0,
                'total_potongan'    => 0,
                'total_dibayar'     => 0,
            ]);

            $detailList = [];

            // ============================
            // 2. KOMPONEN UMUM
            // ============================
            $komponenUmum = KomponenGaji::where('is_umum', 1)
                ->whereNotNull('umum_id')
                ->with('umum') // relasi ke gaji_umum
                ->get();

            foreach ($komponenUmum as $komp) {
                $detailList[] = [
                    'komponen_id'   => $komp->komponen_id,
                    'nominal'       => $komp->umum->nominal,
                    'keterangan'    => 'Komponen Umum',
                ];
            }

            // ============================
            // 3. KOMPONEN JABATAN
            // ============================
            $komponenJabatan = DB::table('tabel_gaji_jabatan')
                ->where('gaji_master_id', $data['gaji_master_id'])
                ->get();

            foreach ($komponenJabatan as $komp) {
                $detailList[] = [
                    'komponen_id'   => $komp->komponen_id,
                    'nominal'       => $komp->nominal,
                    'keterangan'    => 'Komponen Jabatan',
                ];
            }

            // ============================
            // 4. KOMPONEN MANUAL DARI USER
            // ============================
            if (!empty($data['manual'])) {
                foreach ($data['manual'] as $item) {
                    $detailList[] = [
                        'komponen_id' => $item['komponen_id'],
                        'nominal'     => $item['nominal'],
                        'keterangan'  => $item['keterangan'] ?? 'Manual',
                    ];
                }
            }

            // ============================
            // HINDARI DUPLIKASI KOMPONEN
            // ============================
            $detailList = collect($detailList)
                ->unique('komponen_id')
                ->values()
                ->toArray();

            // ============================
            // 5. SIMPAN gaji_detail
            // ============================
            foreach ($detailList as $detail) {
                GajiDetail::create([
                    'transaksi_id' => $trx->transaksi_id,
                    'komponen_id'  => $detail['komponen_id'],
                    'nominal'      => $detail['nominal'],
                    'keterangan'   => $detail['keterangan'],
                ]);
            }

            // ============================
            // 6. HITUNG TOTAL
            // ============================
            $total_penghasilan = 0;
            $total_potongan    = 0;

            foreach ($detailList as $d) {

                $komponen = KomponenGaji::find($d['komponen_id']);

                if ($komponen->jenis === 'pendapatan') {
                    $total_penghasilan += $d['nominal'];
                } else {
                    $total_potongan += $d['nominal'];
                }
            }

            $total_dibayar = $total_penghasilan - $total_potongan;

            // ============================
            // 7. UPDATE TRX HEADER
            // ============================
            $trx->update([
                'total_penghasilan' => $total_penghasilan,
                'total_potongan'    => $total_potongan,
                'total_dibayar'     => $total_dibayar,
            ]);

            return $trx;
        });
    }
}
