<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assinatura extends Model
{
    protected $table = "assinaturas";
    protected $primaryKey = "assi_codigo";
    public $timestamps = false;
    protected $fillable = [
        "assi_codclie",
        "assi_codplan",
        "assi_status",
        "assi_inicio",
        "assi_fim",
        "assi_gateway_id",
    ];

}
