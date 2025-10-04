<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class movimento extends Model
{
    protected $table = 'mov_bancario';
    
    protected $primaryKey = 'movb_codigo';

    public $timestamps = false; 

    protected $fillable = [
        'movb_codclie',
        'movb_valortotal',
        'movb_valorliquido',
        'movb_situacao',
        'movb_categoria',
        'movb_pessoa',
        'movb_observ',
        'movb_datavenc',
        'movb_databaixa',
        'movb_dataes',
        'movb_forma',
        'movb_natureza',
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'movb_categoria', 'cat_codigo');
    }

    public function condpagamento()
    {
        return $this->belongsTo(CondPagamento::class, 'movb_forma', 'copa_codigo');
    }

    public function parcelas()
    {
        return $this->hasMany(Parcela::class, 'par_codigomov', 'movb_codigo');
    }
    
    public function pessoa()
    {
        return $this->belongsTo(Pessoa::class, 'movb_pessoa','pes_codigo');
    }
}
