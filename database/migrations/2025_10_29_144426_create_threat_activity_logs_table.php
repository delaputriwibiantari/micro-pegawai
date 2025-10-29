<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {

        Schema::create('threat_activity_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ip_address', 45);
            $table->string('country', 100)->nullable();
            $table->char('country_code', 2)->nullable();
            $table->string('region', 10)->nullable();
            $table->string('region_name', 100)->nullable();
            $table->string('city', 100)->nullable();
            $table->string('zip', 20)->nullable();
            $table->decimal('lat', 10, 8)->nullable();
            $table->decimal('lon', 11, 8)->nullable();
            $table->string('timezone', 50)->nullable();
            $table->string('isp', 200)->nullable();
            $table->string('org', 200)->nullable();
            $table->string('as', 200)->nullable();
            $table->string('method', 10);
            $table->text('url');
            $table->text('header_user_agent')->nullable();
            $table->text('referer')->nullable();
            $table->string('browser_detected', 100)->nullable();
            $table->string('os_detected', 100)->nullable();
            $table->string('device_type', 50)->nullable();
            $table->tinyInteger('validation_score')->unsigned()->default(0);
            $table->timestamp('created_at')->useCurrent()->nullable();

            // Optional indexes untuk efisiensi pencarian
            $table->index('ip_address', 'idx_ip_address');
            $table->index('country_code', 'idx_country_code');
            $table->index('method', 'idx_method');
            $table->index('browser_detected', 'idx_browser_detected');
            $table->index('os_detected', 'idx_os_detected');
            $table->index('device_type', 'idx_device_type');
            $table->index('created_at', 'idx_created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('threat_activity_logs');
    }
};
