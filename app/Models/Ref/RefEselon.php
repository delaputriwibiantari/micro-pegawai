<?php

namespace App\Models\Ref;

use Illuminate\Database\Eloquent\Model;
use App\Traits\SkipsEmptyAudit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class RefEselon extends Model implements Auditable
{
    use AuditableTrait;
    use HasFactory;
    use SkipsEmptyAudit {
        SkipsEmptyAudit::transformAudit insteadof AuditableTrait;
    }

    public $timestamps = false;

    protected $table = 'ref_eselon';

    protected $primaryKey = 'id_eselon';

    protected $fillable = [
        'eselon',
    ];

    protected $guarded = [
        'id_eselon',
    ];

    protected $casts = [
        'id_eselon' => 'integer',
    ];

    public function setHubunganKeluargaAttribute($value): void
    {
        $this->attributes['eselon'] = trim(strip_tags($value));
    }
}
