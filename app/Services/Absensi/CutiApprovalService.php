<?php

namespace App\Services\Absensi;

use App\Models\Absensi\Cuti;
use Illuminate\Support\Arr;

final class CutiApprovalService
{
    public function approval(string $cutiId, string $status, array $data) : Cuti
    {
        // $cuti = Cuti::where('cuti_id', $cutiId)
        // ->where('status', 'PENGAJUAN')
        // ->firstOrFail();

        $cuti = Cuti::find($cutiId);

        $cuti->update([
            'status'          => $status,
            'disetujui_oleh'  => auth()->guard('admin')->id(),
            'disetujui_pada'  => now(),
        ]);

        return $cuti;
    }
    public function findById(string $id): ?Cuti
    {
        return Cuti::find($id);
    }
}
