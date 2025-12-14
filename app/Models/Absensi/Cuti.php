<?php

namespace App\Models\Absensi;

use App\Traits\SkipsEmptyAudit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

final class Cuti extends Model implements Auditable
{
    use AuditableTrait;
    use HasFactory;
    use SkipsEmptyAudit {
        SkipsEmptyAudit::transformAudit insteadof AuditableTrait;
    }

    protected $connection = 'att';

    protected $table = 'cuti';
    protected $primaryKey = 'id';
    protected $increamenting = true;
    public $timestamps = false;
    protected $fillable = [
        'cuti_id',
        'jenis_cuti',
        'status',
        'keterangan',
        'tanggal_mulai',
        'tanggal_selesai',
        'total_hari',
        'disetujui_oleh',
        'disetujui_pada',
        'sdm_id'
    ];

    protected $guarded = [
        'id'
    ];

    protected $casts = [
        'id' => 'integer',
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
    ];

    public function getTanggalMulaiAttribute($value): ?string
    {
        return $value ? Carbon::parse($value)->format('Y-m-d') : null;
    }

    public function getTanggalSelesaiAttribute($value): ?string
    {
        return $value ? Carbon::parse($value)->format('Y-m-d') : null;
    }
}
