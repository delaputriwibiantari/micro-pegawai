<?php

namespace App\Services\Absensi;

use App\Models\Absensi\Izin;
use Illuminate\Support\Arr;

final class IzinApprovalService
{
   public function approval(int $id, string $status): Izin
    {
        $izin = Izin::where('id', $id)
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

        $izin->update($data);

        return $izin->fresh();
    }


}
