<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Tutor extends Model {protected $table='tutores'; protected $fillable=["nombre", "parentesco", "telefono", "domicilio"]; public function aspirantes(){return $this->hasMany(Aspirante::class);}}
