<?php

namespace App\Services\Absensi;

use App\Models\Absensi\Cuti;
use Illuminate\Support\Arr;

final class CutiApprovalService
{
    // public function approval(string $cutiId, string $status, array $data) : Cuti
    // {


    //     $cuti = Cuti::find($cutiId);

    //     $cuti->update([
    //         'status'          => $status,
    //         'disetujui_oleh'  => auth()->guard('admin')->id(),
    //         'disetujui_pada'  => now(),
    //     ]);

    //     return $cuti;
    // }

    public function approval(int $id, string $status): Cuti
    {
        $cuti = Cuti::where('id', $id)
            ->where('status', 'PENGAJUAN')
            ->firstOrFail();

        $data = [
            'status' => $status,
            'disetujui_oleh' => auth()->guard('admin')->id(),
        ];

        if ($status === 'DISETUJUI') {
            $data['disetujui_pada'] = now();
        }

        if ($status === 'DITOLAK') {
            $data['disetujui_pada'] = null;
        }

        $cuti->update($data);

        return $cuti->fresh();
    }

}
