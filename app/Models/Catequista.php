<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Catequista extends Model {protected $table='catequistas'; protected $fillable=["nombre", "telefono", "correo"]; public function grupos(){return $this->hasMany(Grupo::class);}}
