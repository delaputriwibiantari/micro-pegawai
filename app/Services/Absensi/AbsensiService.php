<?php

namespace App\Services\Absensi;

use App\Models\Absensi\Absensi;
use App\Models\Absensi\JadwalKerja;
use App\Models\Absensi\JenisAbsensi;
use DomainException;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;

final class AbsensiService
{
    public function getListData(): Collection
    {
        $absensi = DB::connection('att')
            ->table('absensi')
            ->leftJoin('jadwal_kerja', 'absensi.jadwal_id', '=', 'jadwal_kerja.jadwal_id')
            ->leftJoin('jenis_absensi', 'absensi.jenis_absen_id', '=', 'jenis_absensi.jenis_absen_id')
            ->select(
                'absensi.*',
                'jadwal_kerja.nama_jadwal',
                'jadwal_kerja.jam_masuk',
                'jadwal_kerja.jam_batas_masuk',
                'jadwal_kerja.jam_pulang',
                'jadwal_kerja.jam_batas_pulang',
                'jenis_absensi.nama_absen',
                'jenis_absensi.kategori',
                'jenis_absensi.warna'
            )
            ->orderBy('absensi.tanggal')
            ->get();

        $sdm = DB::connection('mysql')
            ->table('sdm')
            ->leftJoin('person', 'person.id', '=', 'sdm.id_person')
            ->select('sdm.id', 'person.nama_lengkap')
            ->get()
            ->keyBy('id');

        $absensi->transform(function ($row) use ($sdm) {
            $row->nama_lengkap = $sdm->get($row->sdm_id)->nama_lengkap ?? null;
            return $row;
        });

        return $absensi;
    }


    public function create(array $data)
{
    $jadwal = JadwalKerja::where('id', $data['jadwal_id'])->firstOrFail();

    $jamMasuk    = Carbon::createFromFormat('H:i', $jadwal->jam_masuk);
    $batasMasuk  = Carbon::createFromFormat('H:i', $jadwal->jam_batas_masuk);
    $jamPulang   = Carbon::createFromFormat('H:i', $jadwal->jam_pulang);
    $batasPulang = Carbon::createFromFormat('H:i', $jadwal->jam_batas_pulang);

    $waktuMulai = Carbon::createFromFormat('H:i', $data['waktu_mulai']);

    if ($waktuMulai->lt($jamMasuk)) {
        return [
            'error' => true,
            'message' => 'Belum memasuki jam kerja'
        ];
    }

    if ($waktuMulai->gt($batasPulang)) {
        return [
            'error' => true,
            'message' => 'Waktu absensi sudah berakhir'
        ];
    }
        // 2. Hitung keterlambatan
        $totalTerlambat = 0;
        $jenisNama = 'HADIR';

        if ($waktuMulai->gt($batasMasuk)) {
            $totalTerlambat = $batasMasuk->diffInHours($waktuMulai);
            $jenisNama = 'TERLAMBAT';
        }

        $jenisAbsensi = JenisAbsensi::where('nama_absen', $jenisNama)->firstOrFail();

       

        // 4. Simpan absensi
        return Absensi::create([
            'absensi_id'       => $this->generateId(),
            'sdm_id'           => $data['sdm_id'],
            'jadwal_id'        => $jadwal->jadwal_id,
            'nama_jadwal'      => $jadwal->nama_jadwal,
            'tanggal'          => $data['tanggal'] ?? now()->format('Y-m-d'),
            'waktu_mulai'      => $data['waktu_mulai'],
            'waktu_selesai'    => $data['waktu_selesai'] ?? null,
            'jam_masuk'        => $jadwal->jam_masuk,
            'jam_batas_masuk'  => $jadwal->jam_batas_masuk,
            'jam_pulang'       => $jadwal->jam_pulang,
            'jam_batas_pulang' => $jadwal->jam_batas_pulang,
            'jenis_absen_id'   => $jenisAbsensi->jenis_absen_id,
            'total_terlambat'  => $totalTerlambat,
        ]);

        throw new HttpResponseException(
            response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => [
                    'waktu_mulai' => ['Belum memasuki jam kerja']
                ]
            ], 422)
        );
    }




    public function getDetailData(string $id)
    {
        $absensi = DB::connection('att')
            ->table('absensi')
            ->leftJoin('jadwal_kerja', 'absensi.jadwal_id', '=', 'jadwal_kerja.jadwal_id')
            ->leftJoin('jenis_absensi', 'absensi.jenis_absen_id', '=', 'jenis_absensi.jenis_absen_id')
            ->leftJoin(DB::connection('mysql')->getDatabaseName() . '.sdm as sdm', 'sdm.id', '=', 'absensi.sdm_id')
            ->leftJoin(DB::connection('mysql')->getDatabaseName() . '.person as person', 'person.id', '=', 'sdm.id_person')
            ->select(
                'absensi.*',
                'jadwal_kerja.nama_jadwal',
                'jadwal_kerja.jam_masuk',
                'jadwal_kerja.jam_batas_masuk',
                'jadwal_kerja.jam_pulang',
                'jadwal_kerja.jam_batas_pulang',
                'jenis_absensi.nama_absen',
                'jenis_absensi.kategori',
                'jenis_absensi.warna',
                'person.nama_lengkap'
            )
            ->where('absensi.id', $id)
            ->first();

        return $absensi;
    }




    public function findById(string $id): ?Absensi
    {
        return Absensi::find($id);
    }

    public function update(Absensi $model, array $data): Absensi
    {
        $model->update($data);
        return $model;
    }


    public function getListDataOrdered(string $orderBy): Collection
    {
        return Absensi::orderBy($orderBy)->get();
    }

    private function generateId(): string
    {
        $last = Absensi::orderBy('absensi_id', 'desc')->first();

        if (!$last) {
            return 'ABS-001';
        }
        $lastNumber = intval(substr($last->absensi_id, 4));

        $newNumber = $lastNumber + 1;

        return 'ABS-' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
    }
}
