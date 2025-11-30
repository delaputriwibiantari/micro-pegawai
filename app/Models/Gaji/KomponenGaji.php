<?php

namespace App\Models\Gaji;

use App\Traits\SkipsEmptyAudit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

final class KomponenGaji extends Model implements Auditable
{
    use AuditableTrait;
    use HasFactory;
    use SkipsEmptyAudit {
        SkipsEmptyAudit::transformAudit insteadof AuditableTrait;
    }

    protected $connection = 'gaji';
    public $timestamps = true;
    protected $table = 'komponen_gaji';
    protected $primaryKey = 'id';
    protected $fillable = [
        'komponen_id',
        'nama_komponen',
        'jenis',
        'deskripsi',
        'is_umum',
        'umum_id'
    ];

    protected $guarded = [
        'id',
    ];

    protected $casts = [
    'id'       => 'integer',
    'is_umum'  => 'boolean',
];
    public function setKomponenIdAttribute($v): void
    {
        $this->attributes['komponen_id'] = $v ? trim(strip_tags($v)) : null;
    }

    public function setNamaKomponenAttribute($v): void
    {
        $this->attributes['nama_komponen'] = $v ? trim(strip_tags($v)) : null;
    }

    public function setJenisAttribute($v): void
    {
        $this->attributes['jenis'] = $v ? trim(strip_tags($v)) : null;
    }

    public function setDeskripsiAttribute($v): void
    {
        $this->attributes['deskripsi'] = $v ? trim(strip_tags($v)) : null;
    }
}
