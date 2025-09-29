<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class pessoa extends Model
{
    protected $table = "pessoa";

    protected $primaryKey = "pes_codigo";

    public $timestamps = false;

    protected $fillable = [
        "pes_codclie",
        "pes_nome",
        "pes_cpfpj",
    ];

    public function pessoa()
    {
        return $this->belongsTo(Pessoa::class);
    }

}
