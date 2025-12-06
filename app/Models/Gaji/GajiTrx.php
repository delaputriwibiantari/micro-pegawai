<?php

namespace App\Models\Gaji;

use App\Traits\SkipsEmptyAudit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

final class GajiTrx extends Model implements Auditable
{
    use AuditableTrait;
    use HasFactory;
    use SkipsEmptyAudit {
        SkipsEmptyAudit::transformAudit insteadof AuditableTrait;
    }

    protected $connection = 'gaji';
    protected $table = 'gaji_trx';
    public $incrementing = true;
    protected $keyType = 'string';
    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'transaksi_id',
        'periode_id',
        'total_penghasil',
        'total_potongan',
        'total_dibayar',
        'id_sdm'
    ];

    protected $guarded = [
        'id',
        'id_sdm'
    ];

    protected $casts = [
        'id' => 'integer',
        'id_sdm' => 'integer'
    ];
}
