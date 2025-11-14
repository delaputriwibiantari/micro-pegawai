<?php

namespace App\Models\sdm;


use App\Traits\SkipsEmptyAudit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable as AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;

final class SdmPendidikan extends Model implements Auditable
{
    use AuditableTrait;
    use HasFactory;
    use SkipsEmptyAudit {
        SkipsEmptyAudit::transformAudit insteadof AuditableTrait;
    }

    public $incrementing = true;
    public $timestamps = true;
    protected $table = 'pendidikan';
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    protected $dateFormat = 'Y-m-d';

    protected $fillable = [
        'id_sdm',
        'id_jenjang_pendidikan',
        'institusi',
        'jurusan',
        'tahun_masuk',
        'tahun_lulus',
        'jenis_nilai',
        'sks',
        'sumber_biaya',
        'file_ijazah',
        'file_transkip',

    ];


    protected $casts =[
        'id_sdm' => 'integer',
        'id' => 'integer',
        'tahun_masuk' => 'integer',
        'tahun_lulus' => 'integer',
        'sks' => 'integer',

    ];

    public function setIdSdmAttribute($value): void
    {
        $this->attributes['id_sdm'] = (int) trim(strip_tags($value));
    }

    public function setInstitusiAttribute($value): void
    {
        $this->attributes['institusi'] = strtoupper(trim(strip_tags($value)));
    }

    public function setJurusanAttribute($value): void
    {
        $this->attributes['jurusan'] = strtoupper(trim(strip_tags($value)));
    }

    // ✅ PERBAIKI - tahun harus tetap integer
    public function setTahunMasukAttribute($value): void
    {
        $this->attributes['tahun_masuk'] = (int) trim(strip_tags($value));
    }

    public function setTahunLulusAttribute($value): void
    {
        $this->attributes['tahun_lulus'] = (int) trim(strip_tags($value));
    }

    // ✅ PERBAIKI - sks harus integer
    public function setSksAttribute($value): void
    {
        $this->attributes['sks'] = $value ? (int) trim(strip_tags($value)) : 0;
    }

    // ✅ TAMBAHKAN MUTATOR untuk field lainnya
    public function setSumberBiayaAttribute($value): void
    {
        $this->attributes['sumber_biaya'] = strtoupper(trim(strip_tags($value)));
    }

    public function setJenisNilaiAttribute($value): void
    {
        $this->attributes['jenis_nilai'] = strtoupper(trim(strip_tags($value)));
    }

}
