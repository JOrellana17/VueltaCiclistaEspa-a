<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /* hacer la migracion */
    public function up(): void
    {
        Schema::create('participas', function (Blueprint $table) {
            $table->id('id_participa');
            $table->foreignId('id_equipo')
                ->constrained(table: 'equipos', column: 'id_equipo')
                ->restrictOnDelete()
                ->cascadeOnUpdate();
            $table->foreignId('id_prueba')
                ->constrained(table: 'pruebas', column: 'id')
                ->restrictOnDelete()
                ->cascadeOnUpdate();
            $table->date('fecha_inicio');
            $table->date('fin_contrato');
            $table->enum('estado', ['activo', 'inactivo'])->default('activo');
            $table->timestamps();
        });
    }

    /* revertir la migracion */
    public function down(): void
    {
        Schema::dropIfExists('participas');
    }
};