<?php

namespace App\Models\Absensi;

use App\Traits\SkipsEmptyAudit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

final class Absensi extends Model implements Auditable
{
    use AuditableTrait;
    use HasFactory;
    use SkipsEmptyAudit {
        SkipsEmptyAudit::transformAudit insteadof AuditableTrait;
    }

    protected $connection = 'att';
    protected $table = 'absensi';
    public $timestamps = false;
    public $incrementing = true;
    protected $primaryKey = 'id';
    protected $dateFormat = 'Y-m-d';
    protected $fillable = [
        'absensi_id',
        'tanggal',
        'jadwal_id',
        'jenis_absen_id',
        'total_terlambat',
        'sdm_id',
        'waktu_selesai',
        'waktu_mulai'
    ];

    protected $guarded = [
        'id'
    ];

    protected $casts = [
        'id' => 'integer',
        'tanggal' => 'date'
    ];

    public function getTanggalAttribute($value): ?string
    {
        return $value ? Carbon::parse($value)->format('Y-m-d') : null;
    }
}
