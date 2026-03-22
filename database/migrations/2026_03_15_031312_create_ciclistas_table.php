<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /* hacer la migracion */
    public function up(): void
    {
        Schema::create('ciclistas', function (Blueprint $table) {
            $table->id('id_ciclistas');
            $table->foreignId('id_equipo')
                ->constrained(table: 'equipos', column: 'id_equipo')
                ->restrictOnDelete()
                ->cascadeOnUpdate();
            $table->foreignId('id_nacionalidad')
                ->constrained(table: 'nacionalidades', column: 'id_nacionalidad')
                ->restrictOnDelete()
                ->cascadeOnUpdate();
            $table->string('nombre', 50);
            $table->date('fecha_nacimiento');
            $table->date('fecha_inicio_contrato');
            $table->date('fecha_fin_contrato');
            $table->enum('estado_contrato', ['activo', 'inactivo'])->default('activo');
            $table->enum('estado', ['activo', 'inactivo'])->default('activo');
            $table->timestamps();
        });
    }

    /* revertir la migracion */
    public function down(): void
    {
        Schema::dropIfExists('ciclistas');
    }
};