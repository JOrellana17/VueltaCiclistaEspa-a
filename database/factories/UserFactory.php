<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/* Fabrica para generar datos de prueba del modelo User */
class UserFactory extends Factory
{
    /* Contrasena generada y reutilizada durante la sesion de factory */
    protected static ?string $password;

    /* Define los valores por defecto para los atributos del modelo */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
        ];
    }

    /* Devuelve el estado con el correo electronico sin verificar */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
