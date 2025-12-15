<?php

namespace App\Services\Absensi;

use App\Models\Absensi\Lembur;

final class LemburApprovalService
{
     public function approval(int $id, string $status): Lembur
    {
        $lembur = Lembur::where('id', $id)
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

        $lembur->update($data);

        return $lembur->fresh();
    }

}
