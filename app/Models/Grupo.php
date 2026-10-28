<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Grupo extends Model {protected $table='grupos'; protected $fillable=["nombre", "horario", "lugar", "catequista_id"]; public function catequista(){return $this->belongsTo(Catequista::class);} public function aspirantes(){return $this->hasMany(Aspirante::class);}}
