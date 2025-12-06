<?php

namespace App\Models\Gaji;

use App\Traits\SkipsEmptyAudit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

final class GajiDetail extends Model implements Auditable
{
    use AuditableTrait;
    use HasFactory;
    use SkipsEmptyAudit {
        SkipsEmptyAudit::transformAudit insteadof AuditableTrait;
    }

    protected $connection = 'gaji';
    protected $table = 'gaji_detail';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'detail_id',
        'komponen_id',
        'nominal',
        'keterangan',
        'transaksi_id'
    ];

    protected $guarded = [
        'id'
    ];

    protected $casts = [
        'id'       => 'integer',
    ];
}
