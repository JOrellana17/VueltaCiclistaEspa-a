<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /* hacer la migracion */
    public function up(): void
    {
        Schema::create('ganadores', function (Blueprint $table) {
            $table->id('id_ganador');
            $table->foreignId('id_prueba')
                ->unique()
                ->constrained(table: 'pruebas', column: 'id')
                ->restrictOnDelete()
                ->cascadeOnUpdate();
            $table->foreignId('id_equipo')
                ->constrained(table: 'equipos', column: 'id_equipo')
                ->restrictOnDelete()
                ->cascadeOnUpdate();
            $table->foreignId('id_ciclista')
                ->constrained(table: 'ciclistas', column: 'id_ciclistas')
                ->restrictOnDelete()
                ->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /* revertir la migracion */
    public function down(): void
    {
        Schema::dropIfExists('ganadores');
    }
};
