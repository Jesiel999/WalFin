<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CondPagamento extends Model
{
    protected $table = 'cond_pagamento';

    protected $primaryKey = 'copa_codigo';

    public $timestamps = false;

    protected $fillable = [
        'copa_codclie',
        'copa_nome',
        'copa_desc',
        'copa_tipo', 
        'copa_intervalo',
        'copa_parcelas',
        'copa_status',
    ];

    public function Movimento()
    {
        return $this->hasMany(Movimento::class, 'movb_forma', 'copa_codigo');
    }
}
