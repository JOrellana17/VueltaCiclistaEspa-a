<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /* hacer la migracion */
    public function up(): void
    {
        Schema::create('equipos', function (Blueprint $table) {
            $table->id('id_equipo');
            $table->string('nombre', 50);
            $table->string('director', 50);
            $table->foreignId('id_nacionalidad')
                ->constrained(table: 'nacionalidades', column: 'id_nacionalidad')
                ->restrictOnDelete()
                ->cascadeOnUpdate();
            $table->enum('estado', ['activo', 'inactivo'])->default('activo');
            $table->timestamps();
        });
    }

    /* revertir la migracion */
    public function down(): void
    {
        Schema::dropIfExists('equipos');
    }
};