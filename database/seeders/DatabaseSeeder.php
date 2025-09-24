<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Aqui você chama os seeders que deseja executar
        $this->call([
            UsuarioSeeder::class,
        ]);
    }
}
