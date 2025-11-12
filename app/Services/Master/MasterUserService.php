<?php

namespace App\Services\Master;

use App\Models\App\Admin;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;

final class MasterUserService
{
    public function getListData(): Collection
    {
        return Admin::all();
    }

    public function create(array $data): Admin
    {
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        return Admin::create($data);
    }

    public function getDetailData(string $id): ?Admin
    {
        return Admin::query()->where('admin.id', $id)->first();
    }

    public function findById(string $id): ?Admin
    {
        return Admin::find($id);
    }

    public function update(Admin $admin, array $data): Admin
    {
        if (isset($data['password']) && $data['password']) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']); // Jangan ubah password lama jika kosong
        }

        $admin->update($data);

        return $admin;
    }
}
