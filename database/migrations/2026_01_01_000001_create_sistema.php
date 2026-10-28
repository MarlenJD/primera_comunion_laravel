<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
 public function up(): void {
  Schema::create('users', function(Blueprint $t){$t->id();$t->string('name');$t->string('email')->unique();$t->string('password');$t->enum('rol',['administrador','encargado','coordinador','catequista'])->default('encargado');$t->rememberToken();$t->timestamps();});
  Schema::create('catequistas',function(Blueprint $t){$t->id();$t->string('nombre');$t->string('telefono',30)->nullable();$t->string('correo')->nullable();$t->timestamps();});
  Schema::create('grupos',function(Blueprint $t){$t->id();$t->string('nombre')->unique();$t->string('horario')->nullable();$t->string('lugar')->nullable();$t->foreignId('catequista_id')->nullable()->constrained('catequistas')->nullOnDelete();$t->timestamps();});
  Schema::create('tutores',function(Blueprint $t){$t->id();$t->string('nombre');$t->enum('parentesco',['padre','madre','tutor']);$t->string('telefono',30);$t->string('domicilio')->nullable();$t->timestamps();});
  Schema::create('aspirantes',function(Blueprint $t){$t->id();$t->string('nombre');$t->date('fecha_nacimiento');$t->string('domicilio');$t->string('bautismo')->nullable();$t->text('observaciones')->nullable();$t->foreignId('tutor_id')->constrained('tutores')->restrictOnDelete();$t->foreignId('grupo_id')->nullable()->constrained('grupos')->nullOnDelete();$t->date('fecha_inscripcion');$t->enum('estado',['pendiente','en_revision','confirmada'])->default('pendiente');$t->foreignId('registrado_por')->nullable()->constrained('users')->nullOnDelete();$t->timestamps();$t->index(['nombre','fecha_nacimiento']);});
  Schema::create('documentos',function(Blueprint $t){$t->id();$t->string('nombre')->unique();$t->boolean('obligatorio')->default(true);$t->timestamps();});
  Schema::create('aspirante_documento',function(Blueprint $t){$t->id();$t->foreignId('aspirante_id')->constrained('aspirantes')->cascadeOnDelete();$t->foreignId('documento_id')->constrained('documentos')->cascadeOnDelete();$t->date('fecha_entrega')->nullable();$t->unique(['aspirante_id','documento_id']);});
 }
 public function down(): void {foreach(['aspirante_documento','documentos','aspirantes','tutores','grupos','catequistas','users'] as $x) Schema::dropIfExists($x);}
};
