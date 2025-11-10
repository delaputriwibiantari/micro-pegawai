<?php

namespace App\Models\sdm;


use App\Traits\SkipsEmptyAudit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable as AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Support\Str;
use Carbon\Carbon;

final class SdmDokumen extends Model implements Auditable
{
    use AuditableTrait;
    use HasFactory;
    use SkipsEmptyAudit {
        SkipsEmptyAudit::transformAudit insteadof AuditableTrait;
    }

    public $incrementing = false;
    public $timestamps = true;
    protected $table = 'dokumen';
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    protected $dateFormat = 'Y-m-d';

    protected $fillable = [
        'id',
        'id_sdm',
        'id_jenis_dokumen',
        'nama_dokumen',
        'file_dokumen',

    ];

    protected $guarded = [
        'id',
    ];

    protected $casts =[
        'id_sdm' => 'integer',
        'id' => 'integer',
        'id_jenis_dokumen' => 'integer',

    ];

    public function setIdSdmAttribute($value): void
    {
        $this->attributes['id_sdm'] = trim(strip_tags($value));
    }

    public function setNamaDokumenAttribute($value): void
    {
        $this->attributes['nama_dokumen'] = strtoupper(trim(strip_tags($value)));
    }
    

}
