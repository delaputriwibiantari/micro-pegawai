<?php

namespace App\Models\App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use HasFactory;

    public $timestamps = false;
    protected $keyType = 'string';
    protected $primaryKey = 'id';
    protected $table = 'admin';

    // PERBAIKI: sesuaikan dengan nama kolom di database
    protected $fillable = [
        'nama',      // dari 'name' jadi 'nama'
        'email',
        'password',  // TAMBAHKAN password ke fillable
        'role',
        'otp',
    ];

    // PERBAIKI: hapus password dari guarded
    protected $guarded = [
        'id'
    ];

    protected $hidden = [
        'password',
    ];

    protected $guard = 'admin';
}
