<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('threat_logs', function (Blueprint $table) {
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
            $table->longText('parameters')->nullable();
            $table->string('threat_category', 100);
            $table->text('threat_description')->nullable();
            $table->string('browser_detected', 100)->nullable();
            $table->string('os_detected', 100)->nullable();
            $table->string('device_type', 50)->nullable();
            $table->boolean('is_legitimate')->default(0);
            $table->unsignedTinyInteger('validation_score')->default(0);
            $table->timestamp('created_at')->useCurrent();

            // Indexes
            $table->index('ip_address', 'idx_ip_address');
            $table->index('country_code', 'idx_country_code');
            $table->index('threat_category', 'idx_threat_category');
            $table->index('created_at', 'idx_created_at');
            $table->index('is_legitimate', 'idx_is_legitimate');
            $table->index('validation_score', 'idx_validation_score');
            $table->index(['ip_address', 'created_at'], 'idx_ip_created');
            $table->index(['country_code', 'created_at'], 'idx_country_created');
            $table->index(['threat_category', 'created_at'], 'idx_threat_created');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('threat_logs');
    }
};
