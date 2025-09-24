<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriaSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('categoria')->insert([
            [
                'cat_codclie'   => '',
                'cat_nome'      => 'Alimentação',
                'cat_icone'     => 'fa-utensils'
            ],
        ]);
    }
}
