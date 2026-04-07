<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /* Crea la tabla de usuarios del sistema e inserta los tres roles de ejemplo */
    public function up(): void
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id();
            $table->string('usuario', 60)->unique();
            $table->string('password');
            $table->unsignedTinyInteger('tipo_usuario')->comment('0=Administrador, 1=Encargado, 2=Ciclista, 3=Usuario');
            $table->unsignedBigInteger('id_ciclista')->nullable();
            $table->foreign('id_ciclista')
                ->references('id_ciclistas')
                ->on('ciclistas')
                ->nullOnDelete()
                ->cascadeOnUpdate();
            $table->timestamp('created_at')->useCurrent();
        });

        /* Inserta los tres usuarios iniciales con sus respectivos niveles de acceso */
        DB::table('usuarios')->insert([
            [
                'usuario'      => 'admin',
                'password'     => Hash::make('admin123'),
                'tipo_usuario' => 0,
            ],
            [
                'usuario'      => 'encargado',
                'password'     => Hash::make('encargado123'),
                'tipo_usuario' => 1,
            ],
            [
                'usuario'      => 'ciclista',
                'password'     => Hash::make('ciclista123'),
                'tipo_usuario' => 2,
            ],
        ]);
    }

    /* Elimina la tabla de usuarios al revertir la migración */
    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
