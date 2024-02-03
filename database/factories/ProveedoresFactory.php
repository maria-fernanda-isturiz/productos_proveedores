<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\proveedores;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Proveedores>
 */
class ProveedoresFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = proveedores::class;

    public function definition(): array
    {
        return [
            'nombre' => fake()->name(),
            'direccion' => fake()->sentence(5),
            'telefono' => 60310377,
            'correo' => 'mfibarajas@gmail.com',
            'password' => Hash::make('password'),
        ];
    }
}
