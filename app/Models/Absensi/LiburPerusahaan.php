<?php

namespace App\Models\Absensi;

use App\Traits\SkipsEmptyAudit;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

final class LiburPerusahaan extends Model implements Auditable
{
    use AuditableTrait;
    use HasFactory;
    use SkipsEmptyAudit {
        SkipsEmptyAudit::transformAudit insteadof AuditableTrait;
    }

    protected $connection = 'att';
    protected $table = 'libur_perusahaan';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = false;
    protected $dateFormat = 'Y-m-d';
    protected $fillable = [
        'kalPT_id',
        'tanggal',
        'keterangan'
    ];

    protected $guarded = [
        'id'
    ];

    protected $casts = [
        'tanggal' => 'date'
    ];

    public function getTanggalAttribute($value): ?string
    {
        return $value ? Carbon::parse($value)->format('Y-m-d') : null;
    }
}
