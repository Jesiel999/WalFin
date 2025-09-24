<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;  

class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('usuario')->insert([
            [
                'usua_codigo' => 1,
                'usua_grupo' => 'Admin',
                'usua_nome' => 'Jesiel Santos',
                'usua_senha' => '6253',
                'usua_cpfpj' => '12345678900'
            ],
            [
                'usua_codigo' => 2,
                'usua_grupo' => 'Comum',
                'usua_nome' => 'João Silva',
                'usua_senha' => '1234',
                'usua_cpfpj' => '98765432100'
            ]
        ]);
    }
}
