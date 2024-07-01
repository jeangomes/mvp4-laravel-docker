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
        Schema::create('operations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('negotiation_note_id');
            $table->string('operation_type', 50);
            $table->string('code', 20);
            $table->integer('quantity');
            $table->decimal('price');
            $table->decimal('operation_amount'); // Valor Negociado

            $table->decimal('taxas');
            $table->decimal('total_negociado');
            $table->timestamps();
        });
        Schema::table('operations', function (Blueprint $table) {
            $table->foreign('negotiation_note_id')->references('id')->on('negotiation_notes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('operations');
    }
};
