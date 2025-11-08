<?php

namespace App\Models\Person;

use App\Traits\SkipsEmptyAudit;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

final class PersonAsuransi extends Model implements Auditable
{
    use AuditableTrait;
    use HasFactory;
    use SkipsEmptyAudit {
        SkipsEmptyAudit::transformAudit insteadof AuditableTrait;
    }

    public $timestamps = false;

    public $incrementing = true;

    protected $table = 'asuransi_karyawan';

    protected $primaryKey = 'id';

    protected $keyType = 'int';

    protected $dateFormat = 'Y-m-d';

    protected $fillable = [
        'id_jenis_asuransi',
        'id_person',
        'nomer_peserta',
        'kartu_anggota',
        'status',
        'tanggal_mulai',
        'tanggal_berakhir',
        'keterangan',
    ];

    protected $guarded = ['id'];

    protected $casts = [
        'id' => 'integer',
        'id_jenis_asuransi' => 'integer',
        'id_person' => 'integer',
        'tanggal_mulai' => 'date',
        'tanggal_berakhir' => 'date',
    ];

    public function setNomorPesertaAttribute($v): void
    {
        $this->attributes['nomer_peserta'] = $v ? trim(strip_tags($v)) : null;
    }

    public function setKartuAnggotaAttribute($v): void
    {
        $this->attributes['kartu_anggota'] = $v ? trim(strip_tags($v)) : null;
    }

    public function setStatusAttribute($v): void
    {
        $this->attributes['status'] = $v ? trim(strip_tags($v)) : 'Aktif';
    }

    public function setKeteranganAttribute($v): void
    {
        $this->attributes['keterangan'] = $v === null ? null : trim($v);
    }

    public function getTanggalMulaiAttribute($value): ?string
    {
        return $value ? Carbon::parse($value)->format('Y-m-d') : null;
    }

    public function getTanggalBerakhirAttribute($value): ?string
    {
        return $value ? Carbon::parse($value)->format('Y-m-d') : null;
    }
}
