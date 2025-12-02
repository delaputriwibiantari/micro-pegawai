<?php

namespace App\Models\Gaji;

use App\Traits\SkipsEmptyAudit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

final class TarifLembur extends Model implements Auditable
{
    use AuditableTrait;
    use HasFactory;
    use SkipsEmptyAudit {
        SkipsEmptyAudit::transformAudit insteadof AuditableTrait;
    }

    protected $connection = 'gaji';
    protected $table = 'tarif_lembur';
    protected $primaryKey = 'id';
    protected $dateFormat = 'Y-m-d';
    public $timestamps = false;
    public $incrementing = true;
    protected $fillable = [
        'tarif_id',
        'jenis_lembur',
        'tarif_per_jam',
        'berlaku_mulai'
    ];

    protected $casts = [
        'id' => 'integer',
        'berlaku_mulai' => 'date'
    ];

    public function getBerlakuMulaiAttribute($value): ?string
    {
        return $value ? Carbon::parse($value)->format('Y-m-d') : null;
    }

}
