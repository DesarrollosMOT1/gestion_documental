<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Llamar otros seeders
        $this->call([
            ProductosSeeder::class,
            UnidadesSeeder::class,
            TercerosSeeder::class,
            MotivosSeeder::class,
            TiposYClasesMovimientosSeeder::class,
            BodegasYAlmacenesSeeder::class,
            EquivalenciasTableSeeder::class,
            AreasSeeder::class,
            PermisosSeeder::class,
            ClasificacionesCentroSeeder::class
        ]);
        
        // Crear o encontrar usuario
        $user = User::firstOrCreate(
            [
                'email' => 'sistemasmot8@gmail.com',
            ],
            [
                'name' => 'Administrador',
                'password' => bcrypt('adminmaestri'),
                'id_area' => 1,
            ]
        );

        // Asignar todos los permisos al usuario
        $user->syncPermissions(Permission::all());
    }
}
