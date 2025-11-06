<?php

namespace App\Models\sdm;


use App\Traits\SkipsEmptyAudit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable as AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Support\Str;
use Carbon\Carbon;

final class SdmPendidikan extends Model implements Auditable
{
    use AuditableTrait;
    use HasFactory;
    use SkipsEmptyAudit {
        SkipsEmptyAudit::transformAudit insteadof AuditableTrait;
    }

    public $incrementing = false;
    public $timestamps = false;
    protected $table = 'pendidikan';
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    protected $dateFormat = 'Y-m-d';

    protected $fillable = [
        'id',
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

    protected $guarded = [
        'id',
    ];

    protected $casts =[
        'id_sdm' => 'integer',
        'id' => 'integer',
        'id_sdm' => 'integer',
        'tahun_masuk' => 'integer',
        'tahun_lulus' => 'integer',
        'jumlah_sks' => 'integer',

    ];

    public function setIdSdmAttribute($value): void
    {
        $this->attributes['id_sdm'] = trim(strip_tags($value));
    }

    public function setInstitusiAttribute($value): void
    {
        $this->attributes['institusi'] = strtoupper(trim(strip_tags($value)));
    }
    public function setJurusanAttribute($value): void
    {
        $this->attributes['jurusan'] = strtoupper(trim(strip_tags($value)));
    }

    public function setTahunMasukAttribute($value): void
    {
        $this->attributes['tahun_masuk'] = strtoupper(trim(strip_tags($value)));
    }

    public function setSksAttribute($value): void
    {
        $this->attributes['sks'] = trim(strip_tags($value));
    }

}
