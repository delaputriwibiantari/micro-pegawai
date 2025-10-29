<?php

namespace App\Models\sdm;

use App\Traits\SkipsEmptyAudit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable as AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Support\Str;
use Carbon\Carbon;

final class Sdm extends Model implements Auditable
{
    use AuditableTrait;
    use HasFactory;
    use SkipsEmptyAudit {
        SkipsEmptyAudit::transformAudit insteadof AuditableTrait;
    }

    public $incrementing = true;
    public $timestamps = false;
    protected $table = 'sdm';
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    protected $dateFormat = 'Y-m-d';

    protected $fillable = [
        'nip',
        'status_pegawai',
        'tipe_pegawai',
        'tanggal_masuk',
        'id_person',
    ];

    protected $guarded = [
        'id',
    ];

    protected $casts =[
        'id_person' => 'integer',
        'tanggal_masuk' => 'date',

    ];

    public function setNipAttribute($value): void
    {
        $this->attributes['nip'] = trim(strip_tags($value));
    }

    public function setStatusPegawaiAttribute($value): void
    {
        $this->attributes['status_pegawai'] = $value ? trim(strip_tags($value)) : null;
    }

    public function setTipePegawaiAttribute($value): void
    {
        $this->attributes['tipe_pegawai'] = $value ? trim(strip_tags($value)) : null;
    }

    public function getTanggalMasukAttribute($value): ?string
    {
        return $value ? Carbon::parse($value)->format('Y-m-d') : null;
    }

    public function setIdPersonAttribute($value): void
    {
        $this->attributes['id_person'] = trim(strip_tags($value));
    }

}
