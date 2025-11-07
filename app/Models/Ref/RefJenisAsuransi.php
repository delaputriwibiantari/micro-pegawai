<?php

namespace App\Models\Ref;

use App\Traits\SkipsEmptyAudit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable as AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;

final class RefJenisAsuransi extends Model implements Auditable
{
    use AuditableTrait;
    use HasFactory;
    use SkipsEmptyAudit {
        SkipsEmptyAudit::transformAudit insteadof AuditableTrait;
    }

    public $timestamps = false;

    protected $table = 'ref_jenis_asuransi';

    protected $primaryKey = 'id';

    protected $fillable = [
        'kode_asuransi',
        'nama_asuransi',
        'penyelenggara',
        'tipe_asuransi',
    ];

    protected $guarded = [
        'id',
    ];

    protected $casts = [
        'id' => 'integer',
    ];

    public function setKodeAsuransiAttribute($value): void
    {
        $this->attributes['kode_asuransi'] = trim(strip_tags($value));
    }

    public function setNamaAsuransiAttribute($value): void
    {
        $this->attributes['nama_asuransi'] = trim(strip_tags($value));
    }

    public function setPenyelenggaraAttribute($value): void
    {
        $this->attributes['penyelenggara'] = trim(strip_tags($value));
    }

    public function setTipeAsuransiAttribute($value): void
    {
        $this->attributes['tipe_asuransi'] = trim(strip_tags($value));
    }
}
