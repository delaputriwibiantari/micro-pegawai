<?php

namespace App\Models\Person;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable;

class Person extends Model
{
    use Auditable;

}
