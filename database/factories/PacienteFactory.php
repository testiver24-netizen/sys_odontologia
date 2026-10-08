<?php

namespace Database\Factories;

use App\Models\Paciente;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

/**
 * @extends Factory<Paciente>
 */
class PacienteFactory extends Factory
{
    public function definition(): array
    {
        $nombres   = fake()->firstName();
        $apellidos = fake()->lastName() . ' ' . fake()->lastName();
        $documento = fake()->unique()->numerify('########');
        $email     = fake()->unique()->safeEmail();

        return [
            // Se crea el usuario solo si no pasas un user_id propio
            'user_id' => function () use ($nombres, $apellidos, $documento, $email) {
                Role::findOrCreate('PACIENTE');

                $user = User::create([
                    'name'     => "$nombres $apellidos",
                    'email'    => $email,
                    'password' => Hash::make($documento),
                    'estado'   => 'activo',
                ]);

                $user->assignRole('PACIENTE');

                return $user->id;
            },
            'nombres'             => $nombres,
            'apellidos'           => $apellidos,
            'tipo_documento'      => fake()->randomElement(['CI', 'Pasaporte']),
            'numero_documento'    => $documento,
            'fecha_nacimiento'    => fake()->date('Y-m-d', '-18 years'),
            'genero'              => fake()->randomElement(['M', 'F']),
            'direccion'           => fake()->address(),
            'telefono'            => fake()->numerify('7#######'),
            'grupo_sanguineo'     => fake()->randomElement(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-']),
            'alergias'            => fake()->optional()->sentence(3),
            'enfermedades'        => fake()->optional()->sentence(3),
            'medicamentos'        => fake()->optional()->sentence(3),
            'habitos'             => fake()->optional()->randomElement(['Fuma', 'Bruxismo', 'Fuma, Bruxismo']),
            'antecedentes'        => fake()->optional()->randomElement(['Diabetes', 'Hipertensión', 'Diabetes, Hipertensión']),
            'contacto_emergencia' => fake()->name(),
            'telefono_emergencia' => fake()->numerify('7#######'),
            'observaciones'       => fake()->optional()->sentence(),
        ];
    }
}