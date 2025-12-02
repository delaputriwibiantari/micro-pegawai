<?php

namespace App\Models\Gaji;

use App\Traits\SkipsEmptyAudit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

final class TarifPotongan extends Model implements Auditable
{
    use AuditableTrait;
    use HasFactory;
    use SkipsEmptyAudit {
        SkipsEmptyAudit::transformAudit insteadof AuditableTrait;
    }

    protected $connection = 'gaji';
    protected $primaryKey = 'id';
    protected $table = 'tarif_potongan';
    public $timestamps = false;
    public $incrementing = true;

    protected $fillable = [
        'potongan_id',
        'nama_potongan',
        'tarif_per_kejadian',
        'deskripsi'
    ];

    protected $casts = [
        'id' => 'integer',
    ];


}
