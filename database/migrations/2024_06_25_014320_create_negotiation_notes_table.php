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
        Schema::create('negotiation_notes', function (Blueprint $table) {
            $table->id();
            $table->date('data_pregao'); // Data Pregão
            $table->decimal('valor_liquido');
            $table->decimal('taxa_liquidacao');
            $table->decimal('emolumentos');
            $table->decimal('total_taxa');
            $table->decimal('corretagem');
            $table->decimal('liquido');
            $table->decimal('total');
            $table->string('corretora');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('negotiation_notes');
    }
};
