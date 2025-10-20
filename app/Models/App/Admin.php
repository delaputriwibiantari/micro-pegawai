<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Admin extends Authenticatable
{
    Use HasFactory;
    public $timestamps = false;
    protected $keyType = 'string';
    protected $primaryKey = 'id';
    protected $table = 'admin';

    protected $fillable = [
        'name',
        'email',
        'role',
    ];

    protected $guarded =[
        'password'
    ];

    private string $guard = 'admin';
}
