<?php

namespace App\Models\Person;

use App\Traits\SkipsEmptyAudit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable as AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Support\Str;
use Carbon\Carbon;

final class Person extends Model implements Auditable
{
    use AuditableTrait;
    use HasFactory;
    use SkipsEmptyAudit {
        SkipsEmptyAudit::transformAudit insteadof AuditableTrait;
    }

    public $incrementing = true;
    public $timestamps = false;
    protected $table = 'person';
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    protected $dateFormat = 'Y-m-d';

    protected $fillable = [
        'uuid_person',
        'nama_lengkap',
        'nama_panggilan',
        'tempat_lahir',
        'tanggal_lahir',
        'agama',
        'kewarganegaraan',
        'email',
        'no_hp',
        'nik',
        'kk',
        'npwp',
        'alamat',
        'id_desa',
        'jk',
        'golongan_darah',
        'rt',
        'rw',
        'foto',
    ];

    protected $guarded = [
        'id',
    ];

    protected $casts =[
        'id_person' => 'integer',
        'id_desa' => 'integer',
        'tanggal_lahir' => 'date',

    ];

    protected static function boot(): void
    {
        parent::boot();

        Person::creating(function ($model) {
            if (empty($model->uuid_person)) {
                $model->uuid_person = (string)Str::uuid();
            }
        });
    }


    public function setNamaLengkapAttribute($value): void
    {
        $this->attributes['nama_lengkap'] = strtoupper(trim(strip_tags($value)));
    }
    public function setNamaPanggilanAttribute($value): void
    {
        $this->attributes['nama_panggilan'] = strtoupper(trim(strip_tags($value)));
    }
    public function setTenpatLahirAttribute($value): void
    {
        $this->attributes['tempat_lahir'] = trim(strip_tags($value));
    }

    public function setAgamaAttribute($value): void
    {
        $this->attributes['agama'] = trim(strip_tags($value));
    }

    public function setKewarganegaraanAttribute($value): void
    {
        $this->attributes['kewarganegaraan'] = $value ? trim($value) : 'Indonesia';
    }

    public function setEmailAttribute($value): void
    {
        $this->attributes['email'] = $value ? trim(strip_tags($value)) : null;
    }

    public function setNomorHpAttribute($value): void
    {
        $this->attributes['no_hp'] = $value ? trim(strip_tags($value)) : null;
    }

    public function setNikAttribute($value): void
    {
        $this->attributes['nik'] = trim(strip_tags($value));
    }

    public function setNomorKkAttribute($value): void
    {
        $this->attributes['kk'] = trim(strip_tags($value));
    }

    public function setNpwpAttribute($value): void
    {
        $this->attributes['npwp'] = $value ? trim(strip_tags($value)) : null;
    }

    public function setAlamatAttribute($value): void
    {
        $this->attributes['alamat'] = trim(strip_tags($value));
    }

    public function setIdDesaAttribute($value): void
    {
        $this->attributes['id_desa'] = trim(strip_tags($value));
    }

    public function setGolonganDarahAttribute($value): void
    {
        $this->attributes['golongan_darah'] = $value ? trim(strip_tags($value)) : null;
    }

    public function setRtAttribute($value): void
    {
        $this->attributes['rt'] = trim(strip_tags($value));
    }

    public function setRwAttribute($value): void
    {
        $this->attributes['rw'] = trim(strip_tags($value));
    }

    public function setFotoAttribute($value): void
    {
        $this->attributes['foto'] = $value ? trim(strip_tags($value)) : null;
    }

    public function getTanggalLahirAttribute($value): ?string
    {
        return $value ? Carbon::parse($value)->format('Y-m-d') : null;
    }


}
