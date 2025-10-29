<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::connection('log')->hasTable('threat_blacklist_logs')) {
            Schema::connection('log')->create('threat_blacklist_logs', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('ip_address', 45);
                $table->string('country', 100)->nullable();
                $table->char('country_code', 2)->nullable();
                $table->string('region', 100)->nullable();
                $table->string('region_name', 100)->nullable();
                $table->string('city', 100)->nullable();
                $table->string('zip', 20)->nullable();
                $table->decimal('lat', 10, 8)->nullable();
                $table->decimal('lon', 11, 8)->nullable();
                $table->string('timezone', 50)->nullable();
                $table->string('isp', 200)->nullable();
                $table->string('org', 200)->nullable();
                $table->string('as', 200)->nullable();
                $table->string('method', 10)->nullable();
                $table->text('url')->nullable();
                $table->string('header_user_agent', 500)->nullable(); // ✅ DIKURANGI dari 1000 ke 500
                $table->text('referer')->nullable();
                $table->longText('parameters')->nullable();
                $table->string('threat_category', 100)->nullable();
                $table->text('threat_description')->nullable();
                $table->string('browser_detected', 100)->nullable();
                $table->string('os_detected', 100)->nullable();
                $table->string('device_type', 50)->nullable();
                $table->boolean('is_legitimate')->default(0);
                $table->unsignedTinyInteger('validation_score')->default(0);
                $table->timestamp('created_at')->useCurrent();

                // --- Index Section ---
                // ✅ DIUBAH: Hapus unique constraint yang bermasalah
                // $table->unique(['ip_address', 'header_user_agent'], 'idx_unique_ip_ua');

                // ✅ GUNAKAN INI: Regular indexes saja
                $table->index('ip_address', 'idx_ip_address');
                $table->index(['ip_address', 'created_at'], 'idx_ip_created');
                $table->index('country_code', 'idx_country_code');
                $table->index('created_at', 'idx_created_at');
                $table->index([\Illuminate\Support\Facades\DB::raw('header_user_agent(100)')], 'idx_user_agent_partial');
            });
        }
    }

    public function down(): void
    {
        Schema::connection('log')->dropIfExists('threat_blacklist_logs');
    }
};
