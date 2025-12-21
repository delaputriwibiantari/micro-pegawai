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
        'nama',
        'jam_mulai',
        'jam_selesai',
    ];

    protected $guarded = [
        'id'
    ];

    protected $casts = [
        'id' => 'integer',
    ];

    public function getJamMulaiAttribute($value): ?string
    {
        return $value ? Carbon::parse($value)->format('H:i') : null;
    }

    public function getJamSelesaiAttribute($value): ?string
    {
        return $value ? Carbon::parse($value)->format('H:i') : null;
    }



}
