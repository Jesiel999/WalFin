<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CondPagamentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('cond_pagamento')->insert([
            [
            'copa_codclie'      => 5,
            'copa_nome'         =>'Cartão de crédito 2x',
            'copa_desc'         =>'Parcelamento em 2 vezes no cartão',
            'copa_tipo'         =>'A prazo',
            'copa_intervalo'    => 30,
            'copa_parcelas'     => 2,
            'copa_status'       => 1
            ]
        ]);
    }
}
