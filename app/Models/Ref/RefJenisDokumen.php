<?php

namespace App\Models\Ref;

use App\Traits\SkipsEmptyAudit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

final class RefJenisDokumen extends Model implements Auditable
{
    use AuditableTrait;
    use HasFactory;
    use SkipsEmptyAudit {
        SkipsEmptyAudit::transformAudit insteadof AuditableTrait;
    }

    public $timestamps = false;

    protected $table = 'ref_jenis_dokumen';

    protected $primaryKey = 'id_jenis_dokumen';

    protected $fillable = [
        'jenis_dokumen',
    ];

    protected $guarded = [
        'id_jenis_dokumen',
    ];

    protected $casts = [
        'id_jenis_dokumen' => 'integer',
    ];

    public function setJenisDokumenAttribute($value): void
    {
        $this->attributes['jenis_dokumen'] = trim(strip_tags($value));
    }
}
