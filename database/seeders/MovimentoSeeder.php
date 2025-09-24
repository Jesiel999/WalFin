<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;  

class MovimentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('mov_bancario')->insert([
            [
                'movb_codclie' => 3,
                'movb_cliente' => 'Jesiel',
                'movb_codigo'       => 1,
                'movb_valortotal'   => 2500,
                'movb_valorliquido' => 2500,
                'movb_situacao'     => 'Pago',
                'movb_categoria_id' => '2',
                'movb_categoria'     => 'Transporte',
                'movb_cpfpj'        => '01632178150',
                'movb_pessoa'       => 'Paulo Ferreira',
                'movb_observ'       => 'Conserto Bike',
                'movb_datavenc'     => '2025-12-29', // formato correto
                'movb_databaixa'    => '2025-12-29',
                'movb_dataes'       => '2025-08-08',
                'movb_forma'        => 'Pix',
                'movb_natureza'     => 'Saída',
            ]
        ]);
    }
}
