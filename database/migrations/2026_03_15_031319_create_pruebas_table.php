<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /* hacer la migracion */
    public function up(): void
    {
        Schema::create('pruebas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 50);
            $table->integer('numero_etapas');
            $table->integer('anio_edicion');
            $table->integer('km_totales');
            $table->enum('estado', ['activo', 'inactivo'])->default('activo');
            $table->timestamps();
        });
    }

    /* revertir la migracion */
    public function down(): void
    {
        Schema::dropIfExists('pruebas');
    }
};