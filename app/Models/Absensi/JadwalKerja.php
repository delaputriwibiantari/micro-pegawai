<?php

namespace App\Models\Absensi;

use App\Traits\SkipsEmptyAudit;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

final class JadwalKerja extends Model implements Auditable
{
    use AuditableTrait;
    use HasFactory;
    use SkipsEmptyAudit {
        SkipsEmptyAudit::transformAudit insteadof AuditableTrait;
    }

    protected $connection = 'att';

    protected $table = 'jadwal_kerja';
    protected $primaryKey = 'id';
    protected $timeFormat = 'H:i';
    protected $increamenting = true;
    public $timestamps = false;
    protected $fillable = [
        'jadwal_id',
        'nama_jadwal',
        'jam_masuk',
        'jam_pulang',
        'jam_batas_masuk',
        'jam_batas_pulang',
        'toleransi_terlambat'
    ];

    protected $guarded = [
        'id'
    ];

    protected $casts = [
        'toleransi_terlambat' => 'integer',
    ];

    public function getJamMasukAttribute($value): ?string
    {
        return $value ? Carbon::parse($value)->format('H:i') : null;
    }

    public function getJamPulangAttribute($value): ?string
    {
        return $value ? Carbon::parse($value)->format('H:i') : null;
    }

    public function getJamBatasMasukAttribute($value): ?string
    {
        return $value ? Carbon::parse($value)->format('H:i') : null;
    }

    public function getJamBatasPulangAttribute($value): ?string
    {
        return $value ? Carbon::parse($value)->format('H:i') : null;
    }


}
