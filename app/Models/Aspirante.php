<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Aspirante extends Model {protected $table='aspirantes'; protected $fillable=["nombre", "fecha_nacimiento", "domicilio", "bautismo", "observaciones", "tutor_id", "grupo_id", "fecha_inscripcion", "estado", "registrado_por"]; public function tutor(){return $this->belongsTo(Tutor::class);} public function grupo(){return $this->belongsTo(Grupo::class);} public function documentos(){return $this->belongsToMany(Documento::class,'aspirante_documento')->withPivot('fecha_entrega');}}
