<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
class DatabaseSeeder extends Seeder {
 public function run(): void {
  DB::table('users')->updateOrInsert(['email'=>'admin@comunion.local'],['name'=>'Administrador','password'=>Hash::make('Admin12345!'),'rol'=>'administrador','created_at'=>now(),'updated_at'=>now()]);
  foreach(['Acta de nacimiento','Fe de bautismo','CURP','Fotografía','Identificación del tutor'] as $nombre) DB::table('documentos')->updateOrInsert(['nombre'=>$nombre],['obligatorio'=>true,'created_at'=>now(),'updated_at'=>now()]);
 }
}
