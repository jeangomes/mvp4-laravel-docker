<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('financial_assets', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code', 20);
            $table->boolean('is_foreigner')->default(false);
            $table->enum('asset_type', ['ETF', 'Stock', 'FII', 'Crypto', 'RF']);
            $table->enum('stock_type', ['ON', 'PN', 'UNIT'])->nullable();
            $table->string('cnpj', 20)->nullable();
            $table->string('fii_admin_name')->nullable();
            $table->string('fii_admin_cnpj', 20)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('financial_assets');
    }
};
