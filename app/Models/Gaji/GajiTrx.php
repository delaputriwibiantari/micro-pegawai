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
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;
    protected $primaryKey = 'transaksi_id';
    protected $fillable = [
        'id',
        'transaksi_id',
        'periode_id',
        'total_penghasil',
        'total_potongan',
        'total_dibayar',
        'sdm_id'
    ];


    protected $casts = [
        'id' => 'integer',
        'sdm_id' => 'integer'
    ];

    public function details()
    {
        return $this->hasMany(GajiDetail::class, 'transaksi_id', 'transaksi_id');
    }
}
