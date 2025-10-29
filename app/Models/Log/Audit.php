<?php

namespace App\Models\Log;

use OwenIt\Auditing\Models\Audit as BaseAudit;

class Audit extends BaseAudit
{
    protected $connection = 'log'; // ✅ Gunakan koneksi log

    protected $table = 'audits';
}
