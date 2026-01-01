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
    protected static function booted()
    {
        static::creating(function ($model) {
            if (empty($model->detail_id)) {
                // Generates format GD-YYMM-XXXXX (e.g., GD-2512-00001)
                $prefix = 'GD-' . date('ym') . '-';
                $last = self::where('detail_id', 'like', $prefix . '%')->orderBy('detail_id', 'desc')->first();
                $seq = 1;
                if ($last) {
                    $parts = explode('-', $last->detail_id);
                    $seq = intval(end($parts)) + 1;
                }
                $model->detail_id = $prefix . str_pad($seq, 5, '0', STR_PAD_LEFT);
            }
        });
    }

    protected $connection = 'gaji';
    protected $table = 'gaji_detail';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $fillable = [
        'detail_id',
        'komponen_id',
        'nominal',
        'keterangan',
        'transaksi_id',
        'sumber_nominal',
        'referensi_id'
    ];

    protected $guarded = [
        'id'
    ];

    protected $casts = [
        'id'       => 'integer',
    ];
}
