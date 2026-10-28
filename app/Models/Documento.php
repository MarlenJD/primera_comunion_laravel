<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Documento extends Model {protected $table='documentos'; protected $fillable=["nombre", "obligatorio"]; protected function casts(): array {return ['obligatorio'=>'boolean'];}}
