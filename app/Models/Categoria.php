<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
   protected $table = 'categoria';

   protected $primaryKey = 'cat_codigo';

   public $timestamps = false;

   protected $fillable = [
    'cat_codclie',
    'cat_codigo',
    'cat_nome',
    'cat_icone',
   ];

   public function Movimento()
   {
      return $this->hasMany(Movimento::class, 'movb_categoria', 'cat_codigo');
   } 
}
