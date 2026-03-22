<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /* hacer la migracion */
    public function up(): void
    {
        Schema::create('nacionalidades', function (Blueprint $table) {
            $table->id('id_nacionalidad');
            $table->string('codigo_iso', 3)->unique();
            $table->string('nombre', 50)->unique();
            $table->timestamps();
        });

        DB::table('nacionalidades')->insert([
            ['codigo_iso' => 'AFG', 'nombre' => 'Afganistán', 'created_at' => now(), 'updated_at' => now()],
            ['codigo_iso' => 'DEU', 'nombre' => 'Alemania', 'created_at' => now(), 'updated_at' => now()],
            ['codigo_iso' => 'SAU', 'nombre' => 'Arabia Saudí', 'created_at' => now(), 'updated_at' => now()],
            ['codigo_iso' => 'ARG', 'nombre' => 'Argentina', 'created_at' => now(), 'updated_at' => now()],
            ['codigo_iso' => 'ARM', 'nombre' => 'Armenia', 'created_at' => now(), 'updated_at' => now()],
            ['codigo_iso' => 'AUS', 'nombre' => 'Australia', 'created_at' => now(), 'updated_at' => now()],
            ['codigo_iso' => 'AUT', 'nombre' => 'Austria', 'created_at' => now(), 'updated_at' => now()],
            ['codigo_iso' => 'BHR', 'nombre' => 'Bahrein', 'created_at' => now(), 'updated_at' => now()],
            ['codigo_iso' => 'BGD', 'nombre' => 'Bangladesh', 'created_at' => now(), 'updated_at' => now()],
            ['codigo_iso' => 'BRB', 'nombre' => 'Barbados', 'created_at' => now(), 'updated_at' => now()],
            ['codigo_iso' => 'BEL', 'nombre' => 'Bélgica', 'created_at' => now(), 'updated_at' => now()],
            ['codigo_iso' => 'BLR', 'nombre' => 'Bielorusia', 'created_at' => now(), 'updated_at' => now()],
            ['codigo_iso' => 'BOL', 'nombre' => 'Bolivia', 'created_at' => now(), 'updated_at' => now()],
            ['codigo_iso' => 'BIH', 'nombre' => 'Bosnia', 'created_at' => now(), 'updated_at' => now()],
            ['codigo_iso' => 'BWA', 'nombre' => 'Botswana', 'created_at' => now(), 'updated_at' => now()],
            ['codigo_iso' => 'BRA', 'nombre' => 'Brasil', 'created_at' => now(), 'updated_at' => now()],
            ['codigo_iso' => 'BGR', 'nombre' => 'Bulgaria', 'created_at' => now(), 'updated_at' => now()],
            ['codigo_iso' => 'BFA', 'nombre' => 'Burkina Faso', 'created_at' => now(), 'updated_at' => now()],
            ['codigo_iso' => 'BDI', 'nombre' => 'Burundi', 'created_at' => now(), 'updated_at' => now()],
            ['codigo_iso' => 'KHM', 'nombre' => 'Camboya', 'created_at' => now(), 'updated_at' => now()],
            ['codigo_iso' => 'CMR', 'nombre' => 'Camerún', 'created_at' => now(), 'updated_at' => now()],
            ['codigo_iso' => 'CAN', 'nombre' => 'Canadá', 'created_at' => now(), 'updated_at' => now()],
            ['codigo_iso' => 'CHL', 'nombre' => 'Chile', 'created_at' => now(), 'updated_at' => now()],
            ['codigo_iso' => 'CHN', 'nombre' => 'China', 'created_at' => now(), 'updated_at' => now()],
            ['codigo_iso' => 'COL', 'nombre' => 'Colombia', 'created_at' => now(), 'updated_at' => now()],
            ['codigo_iso' => 'PRK', 'nombre' => 'Corea del Norte', 'created_at' => now(), 'updated_at' => now()],
            ['codigo_iso' => 'KOR', 'nombre' => 'Corea del Sur', 'created_at' => now(), 'updated_at' => now()],
            ['codigo_iso' => 'CRI', 'nombre' => 'Costa Rica', 'created_at' => now(), 'updated_at' => now()],
            ['codigo_iso' => 'HRV', 'nombre' => 'Croacia', 'created_at' => now(), 'updated_at' => now()],
            ['codigo_iso' => 'CUB', 'nombre' => 'Cuba', 'created_at' => now(), 'updated_at' => now()],
            ['codigo_iso' => 'DNK', 'nombre' => 'Dinamarca', 'created_at' => now(), 'updated_at' => now()],
            ['codigo_iso' => 'ECU', 'nombre' => 'Ecuador', 'created_at' => now(), 'updated_at' => now()],
            ['codigo_iso' => 'EGY', 'nombre' => 'Egipto', 'created_at' => now(), 'updated_at' => now()],
            ['codigo_iso' => 'SLV', 'nombre' => 'El Salvador', 'created_at' => now(), 'updated_at' => now()],
            ['codigo_iso' => 'ARE', 'nombre' => 'Emiratos Árabes', 'created_at' => now(), 'updated_at' => now()],
            ['codigo_iso' => 'ESP', 'nombre' => 'España', 'created_at' => now(), 'updated_at' => now()],
            ['codigo_iso' => 'USA', 'nombre' => 'Estados Unidos', 'created_at' => now(), 'updated_at' => now()],
            ['codigo_iso' => 'EST', 'nombre' => 'Estonia', 'created_at' => now(), 'updated_at' => now()],
            ['codigo_iso' => 'ETH', 'nombre' => 'Etiopía', 'created_at' => now(), 'updated_at' => now()],
            ['codigo_iso' => 'PHL', 'nombre' => 'Filipinas', 'created_at' => now(), 'updated_at' => now()],
            ['codigo_iso' => 'FIN', 'nombre' => 'Finlandia', 'created_at' => now(), 'updated_at' => now()],
            ['codigo_iso' => 'FRA', 'nombre' => 'Francia', 'created_at' => now(), 'updated_at' => now()],
            ['codigo_iso' => 'GAB', 'nombre' => 'Gabón', 'created_at' => now(), 'updated_at' => now()],
            ['codigo_iso' => 'GMB', 'nombre' => 'Gambia', 'created_at' => now(), 'updated_at' => now()],
            ['codigo_iso' => 'GEO', 'nombre' => 'Georgia', 'created_at' => now(), 'updated_at' => now()],
            ['codigo_iso' => 'GBR', 'nombre' => 'Gran Bretaña', 'created_at' => now(), 'updated_at' => now()],
            ['codigo_iso' => 'GRC', 'nombre' => 'Grecia', 'created_at' => now(), 'updated_at' => now()],
            ['codigo_iso' => 'GTM', 'nombre' => 'Guatemala', 'created_at' => now(), 'updated_at' => now()],
            ['codigo_iso' => 'HTI', 'nombre' => 'Haití', 'created_at' => now(), 'updated_at' => now()],
            ['codigo_iso' => 'HND', 'nombre' => 'Honduras', 'created_at' => now(), 'updated_at' => now()],
            ['codigo_iso' => 'HKG', 'nombre' => 'Hong Kong', 'created_at' => now(), 'updated_at' => now()],
            ['codigo_iso' => 'HUN', 'nombre' => 'Hungía', 'created_at' => now(), 'updated_at' => now()],
            ['codigo_iso' => 'IND', 'nombre' => 'India', 'created_at' => now(), 'updated_at' => now()],
            ['codigo_iso' => 'IDN', 'nombre' => 'Indonesia', 'created_at' => now(), 'updated_at' => now()],
            ['codigo_iso' => 'IRN', 'nombre' => 'Irán', 'created_at' => now(), 'updated_at' => now()],
            ['codigo_iso' => 'IRQ', 'nombre' => 'Iraq', 'created_at' => now(), 'updated_at' => now()],
            ['codigo_iso' => 'IRL', 'nombre' => 'Irlanda', 'created_at' => now(), 'updated_at' => now()],
            ['codigo_iso' => 'ISL', 'nombre' => 'Islandia', 'created_at' => now(), 'updated_at' => now()],
            ['codigo_iso' => 'ISR', 'nombre' => 'Israel', 'created_at' => now(), 'updated_at' => now()],
            ['codigo_iso' => 'ITA', 'nombre' => 'Italia', 'created_at' => now(), 'updated_at' => now()],
            ['codigo_iso' => 'JPN', 'nombre' => 'Japón', 'created_at' => now(), 'updated_at' => now()],
            ['codigo_iso' => 'JOR', 'nombre' => 'Jordania', 'created_at' => now(), 'updated_at' => now()],
            ['codigo_iso' => 'KEN', 'nombre' => 'Kenia', 'created_at' => now(), 'updated_at' => now()],
            ['codigo_iso' => 'KWT', 'nombre' => 'Kuwait', 'created_at' => now(), 'updated_at' => now()],
            ['codigo_iso' => 'LVA', 'nombre' => 'Letonia', 'created_at' => now(), 'updated_at' => now()],
            ['codigo_iso' => 'LBN', 'nombre' => 'Líbano', 'created_at' => now(), 'updated_at' => now()],
            ['codigo_iso' => 'LBR', 'nombre' => 'Liberia', 'created_at' => now(), 'updated_at' => now()],
            ['codigo_iso' => 'LBY', 'nombre' => 'Libia', 'created_at' => now(), 'updated_at' => now()],
            ['codigo_iso' => 'LTU', 'nombre' => 'Lituania', 'created_at' => now(), 'updated_at' => now()],
            ['codigo_iso' => 'MYS', 'nombre' => 'Malasia', 'created_at' => now(), 'updated_at' => now()],
            ['codigo_iso' => 'MAR', 'nombre' => 'Marruecos', 'created_at' => now(), 'updated_at' => now()],
            ['codigo_iso' => 'MEX', 'nombre' => 'México', 'created_at' => now(), 'updated_at' => now()],
            ['codigo_iso' => 'NIC', 'nombre' => 'Nicaragua', 'created_at' => now(), 'updated_at' => now()],
            ['codigo_iso' => 'NGA', 'nombre' => 'Nigeria', 'created_at' => now(), 'updated_at' => now()],
            ['codigo_iso' => 'NOR', 'nombre' => 'Noruega', 'created_at' => now(), 'updated_at' => now()],
            ['codigo_iso' => 'NZL', 'nombre' => 'Nueva Zelanda', 'created_at' => now(), 'updated_at' => now()],
            ['codigo_iso' => 'NLD', 'nombre' => 'Países Bajos', 'created_at' => now(), 'updated_at' => now()],
            ['codigo_iso' => 'PAK', 'nombre' => 'Pakistán', 'created_at' => now(), 'updated_at' => now()],
            ['codigo_iso' => 'PAN', 'nombre' => 'Panamá', 'created_at' => now(), 'updated_at' => now()],
            ['codigo_iso' => 'PRY', 'nombre' => 'Paraguay', 'created_at' => now(), 'updated_at' => now()],
            ['codigo_iso' => 'PER', 'nombre' => 'Perú', 'created_at' => now(), 'updated_at' => now()],
            ['codigo_iso' => 'POL', 'nombre' => 'Polonia', 'created_at' => now(), 'updated_at' => now()],
            ['codigo_iso' => 'PRT', 'nombre' => 'Portugal', 'created_at' => now(), 'updated_at' => now()],
            ['codigo_iso' => 'CAF', 'nombre' => 'Rep. C. Africana', 'created_at' => now(), 'updated_at' => now()],
            ['codigo_iso' => 'DOM', 'nombre' => 'Rep. Dominicana', 'created_at' => now(), 'updated_at' => now()],
            ['codigo_iso' => 'RWA', 'nombre' => 'Ruanda', 'created_at' => now(), 'updated_at' => now()],
            ['codigo_iso' => 'ROU', 'nombre' => 'Rumanía', 'created_at' => now(), 'updated_at' => now()],
            ['codigo_iso' => 'RUS', 'nombre' => 'Rusia', 'created_at' => now(), 'updated_at' => now()],
            ['codigo_iso' => 'SEN', 'nombre' => 'Senegal', 'created_at' => now(), 'updated_at' => now()],
            ['codigo_iso' => 'SGP', 'nombre' => 'Singapur', 'created_at' => now(), 'updated_at' => now()],
            ['codigo_iso' => 'SYR', 'nombre' => 'Siria', 'created_at' => now(), 'updated_at' => now()],
            ['codigo_iso' => 'SOM', 'nombre' => 'Somalia', 'created_at' => now(), 'updated_at' => now()],
            ['codigo_iso' => 'ZAF', 'nombre' => 'Sudáfrica', 'created_at' => now(), 'updated_at' => now()],
            ['codigo_iso' => 'SWE', 'nombre' => 'Suecia', 'created_at' => now(), 'updated_at' => now()],
            ['codigo_iso' => 'CHE', 'nombre' => 'Suiza', 'created_at' => now(), 'updated_at' => now()],
            ['codigo_iso' => 'THA', 'nombre' => 'Tailandia', 'created_at' => now(), 'updated_at' => now()],
            ['codigo_iso' => 'TWN', 'nombre' => 'Taiwan', 'created_at' => now(), 'updated_at' => now()],
            ['codigo_iso' => 'TZA', 'nombre' => 'Tanzania', 'created_at' => now(), 'updated_at' => now()],
            ['codigo_iso' => 'TUR', 'nombre' => 'Turquía', 'created_at' => now(), 'updated_at' => now()],
            ['codigo_iso' => 'UKR', 'nombre' => 'Ucrania', 'created_at' => now(), 'updated_at' => now()],
            ['codigo_iso' => 'UGA', 'nombre' => 'Uganda', 'created_at' => now(), 'updated_at' => now()],
            ['codigo_iso' => 'URY', 'nombre' => 'Uruguay', 'created_at' => now(), 'updated_at' => now()],
            ['codigo_iso' => 'UZB', 'nombre' => 'Uzbekistán', 'created_at' => now(), 'updated_at' => now()],
            ['codigo_iso' => 'VEN', 'nombre' => 'Venezuela', 'created_at' => now(), 'updated_at' => now()],
            ['codigo_iso' => 'VNM', 'nombre' => 'Vietnam', 'created_at' => now(), 'updated_at' => now()],
            ['codigo_iso' => 'ZMB', 'nombre' => 'Zambia', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    /* revertir la migracion */
    public function down(): void
    {
        Schema::dropIfExists('nacionalidades');
    }
};