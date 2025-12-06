<?php

namespace App\Services\Gaji;

use App\Models\Gaji\GajiDetail;
use App\Models\Gaji\GajiTrx;
use App\Models\Gaji\KomponenGaji;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

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
        return GajiTrx::query()
            ->leftJoin('sdm', 'sdm.id', '=', 'gaji_trx.sdm_id')
            ->leftJoin('gaji_periode', 'gaji_periode.periode_id', '=', 'gaji_trx.periode_id')
            ->select([
                'gaji_trx.*',
                'sdm.nama_lengkap as nama_sdm',
                'gaji_periode.tahun',
                'gaji_periode.status',
            ])
            ->when($request->query('periode_id'), fn($q,$v) => $q->where('gaji_trx.periode_id', $v))
            ->orderBy('gaji_trx.transaksi_id', 'desc')
            ->get();
    }

    public function getDetailTransaksi(string $trxId): ?GajiTrx
    {
        return GajiTrx::query()
            ->leftJoin('sdm', 'sdm.id', '=', 'gaji_trx.sdm_id')
            ->leftJoin('gaji_periode', 'gaji_periode.periode_id', '=', 'gaji_trx.periode_id')
            ->select([
                'gaji_trx.*',
                'sdm.nama_lengkap as nama_sdm',
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
}
