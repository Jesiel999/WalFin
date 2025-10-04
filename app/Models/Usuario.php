<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Usuario extends Model
{
    protected $table = 'usuario';
    protected $primaryKey = 'usua_codigo';
    public $timestamps = false;

    protected $fillable = [
        'usua_grupo',
        'usua_nome',
        'usua_cpfpj',
        'usua_email',
        'usua_telefone',
        'usua_senha',
    ];

    protected static function booted()
    {
        static::created(function ($usuario) {
            $categoriasPadrao = [
                ['cat_codigo' => 1,  'cat_nome' => 'Alimentação',        'cat_icone' => 'fas fa-utensils'],
                ['cat_codigo' => 2,  'cat_nome' => 'Transporte',         'cat_icone' => 'fas fa-car'],
                ['cat_codigo' => 3,  'cat_nome' => 'Salário',            'cat_icone' => 'fas fa-laptop'],
                ['cat_codigo' => 4,  'cat_nome' => 'Doméstico',          'cat_icone' => 'fas fa-home'],
                ['cat_codigo' => 5,  'cat_nome' => 'Lazer',              'cat_icone' => 'fas fa-star'],
                ['cat_codigo' => 6,  'cat_nome' => 'Renda Extra',        'cat_icone' => 'fas fa-globe'],
                ['cat_codigo' => 7,  'cat_nome' => 'Saúde',              'cat_icone' => 'fas fa-heart'],
                ['cat_codigo' => 8,  'cat_nome' => 'Educação',           'cat_icone' => 'fas fa-book'],
                ['cat_codigo' => 9,  'cat_nome' => 'Compras',            'cat_icone' => 'fas fa-shopping-bag'],
                ['cat_codigo' => 10, 'cat_nome' => 'Investimento',       'cat_icone' => 'fas fa-bolt'],
            ];

            foreach ($categoriasPadrao as $cat) {
                DB::table('categoria')->insert([
                    'cat_codclie' => $usuario->usua_codigo,
                    'cat_codigo'  => $cat['cat_codigo'],
                    'cat_nome'    => $cat['cat_nome'],
                    'cat_icone'   => $cat['cat_icone'],
                    'cat_status'   => '1',
                ]);
            }

            $condpagamentoPadrao = [
                ['copa_codigo'=> '1','copa_nome'=> 'Dinheiro','copa_desc'=> ''],
                ['copa_codigo'=> '2','copa_nome'=> 'Cartão de crédito','copa_desc'=> ''],
                ['copa_codigo'=> '3','copa_nome'=> 'Pix','copa_desc'=> ''],
                ['copa_codigo'=> '4','copa_nome'=> 'TED/DOC','copa_desc'=> ''],
                ['copa_codigo'=> '5','copa_nome'=> 'Boleto','copa_desc'=> ''],
                ['copa_codigo'=> '6','copa_nome'=> 'Cheque','copa_desc'=> ''],
                ['copa_codigo'=> '7','copa_nome'=> 'Cartão de débito','copa_desc'=> ''],
            ];

            foreach ($condpagamentoPadrao as $cond){
                DB::table('cond_pagamento')->insert([
                    'copa_codclie'=> $usuario->usua_codigo,
                    'copa_codigo'=> $cond['copa_codigo'],
                    'copa_nome'=> $cond['copa_nome'],
                    'copa_desc'=> $cond['copa_desc'],
                    'copa_status'=> '1',
                ]); 
            }
        });
    }
}
