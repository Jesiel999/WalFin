<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReceitaDespesa extends Model
{
    protected $table = 'mov_bancario';
    
    protected $primaryKey = 'movb_codigo';

    public $timestamps = false; 

    protected $fillable = [
        'movb_codclie',
        'movb_codigo',
        'movb_valortotal',
        'movb_valorliquido',
        'movb_situacao',
        'movb_categoria_id',
        'movb_categoria',
        'movb_cpfpj',
        'movb_pessoa',
        'movb_observ',
        'movb_datavenc',
        'movb_databaixa',
        'movb_dataes',
        'movb_forma',
        'movb_natureza',
    ];

}
