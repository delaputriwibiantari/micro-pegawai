<?php

namespace App\Models\Gaji;

use App\Traits\SkipsEmptyAudit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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
    public $timestamps = false;
    public $incrementing = true;
    protected $fillable = [
        'tarif_id',
        'jenis_lembur',
        'tarif_per_jam',
        'berlaku_sampai'
    ];

    protected $casts = [
        'id' => 'integer',
        'berlaku_sampai' => 'date'
    ];

}
