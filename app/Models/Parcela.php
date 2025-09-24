<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Parcela extends Model
{
    protected $table = 'parcela';

    protected $primaryKey = 'par_codigo';

    public $timestamps = false;

    protected $fillable = [
        'par_codclie',
        'par_codigomov',
        'par_valor',
        'par_numero',
        'par_qtnumero',
        'par_datavenc',
        'par_databaixa',
        'par_situacao',
    ];

    public function movimento()
    {
        return $this->belongsTo(Movimento::class, 'par_codigomov', 'movb_codigo');
    }
    
}
