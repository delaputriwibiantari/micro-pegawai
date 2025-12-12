<?php

namespace App\Models\Absensi;

use App\Traits\SkipsEmptyAudit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

final class JenisAbsensi extends Model implements Auditable
{
    use AuditableTrait;
    use HasFactory;
    use SkipsEmptyAudit {
        SkipsEmptyAudit::transformAudit insteadof AuditableTrait;
    }

    protected $connection = 'att';
    protected $increamenting = true;
    protected $table = 'jenis_absensi';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [
        'jenis_absen_id',
        'nama_absen',
        'kategori',
        'potong_gaji',
        'warna'
    ];

    protected $guarded = [
        'id'
    ];

    protected $casts = [
        'id' => 'integer',
        'potong_gaji' => 'boolean'
    ];

}
