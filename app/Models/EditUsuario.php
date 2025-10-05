<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EditUsuario extends Model
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
    ];
}

