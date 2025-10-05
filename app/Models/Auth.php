<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Auth extends Authenticatable
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

    protected $hidden = ['usua_senha'];

    public function getAuthPassword()
    {
        return $this->usua_senha; 
    }
}
