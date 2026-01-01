<?php

namespace App\Models\Gaji;

use App\Traits\SkipsEmptyAudit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

final class GajiJabatan extends Model implements Auditable
{
    use AuditableTrait;
    use HasFactory;
    use SkipsEmptyAudit {
        SkipsEmptyAudit::transformAudit insteadof AuditableTrait;
    }

    protected $connection = 'gaji';
    protected $increamenting = true;
    public $timestamps = false;
    protected $table = 'gaji_jabatan';
    protected $primaryKey = 'id';
    protected $fillable = [
        'gaji_master_id',
        'komponen_id',
        'id_jabatan',
        'override_nominal',
        'use_override'
    ];


    protected $casts = [
        'id'       => 'integer',
        'id_jabatan' => 'integer',
    ];

    public function komponen()
    {
        return $this->belongsTo(KomponenGaji::class, 'komponen_id', 'komponen_id');
    }


}
