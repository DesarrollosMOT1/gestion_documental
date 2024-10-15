<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $this->call([
            ProductosSeeder::class,
            UnidadesSeeder::class,
            TercerosSeeder::class,
            MotivosSeeder::class,
            TiposYClasesMovimientosSeeder::class,
            BodegasYAlmacenesSeeder::class,,
            AreasSeeder::class,
            PermisosSeeder::class,
            ClasificacionesCentroSeeder::class
        ]);
        
        // Crear o encontrar usuario
        User::firstOrCreate(
            [
                'email' => 'test@example.com',  // Buscará por email
            ],
            [
                'name' => 'Test User',  // Si no lo encuentra, creará con estos atributos
                'password' => bcrypt('password123'),  // No olvides encriptar la contraseña
            ]
        );
    }
}
