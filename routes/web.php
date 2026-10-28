<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{AuthController,DashboardController,AspiranteController,CatalogoController,UsuarioController};
Route::get('/login',[AuthController::class,'form'])->name('login')->middleware('guest');
Route::post('/login',[AuthController::class,'login'])->middleware('guest');
Route::post('/logout',[AuthController::class,'logout'])->name('logout')->middleware('auth');
Route::redirect('/','/dashboard');
Route::middleware('auth')->group(function(){
 Route::get('/dashboard',[DashboardController::class,'index'])->name('dashboard');
 Route::get('/aspirantes/reporte',[AspiranteController::class,'reporte'])->name('aspirantes.reporte');
 Route::patch('/aspirantes/{aspirante}/estado',[AspiranteController::class,'estado'])->name('aspirantes.estado');
 Route::resource('aspirantes',AspiranteController::class);
 Route::get('/catalogos/{tipo}',[CatalogoController::class,'index'])->whereIn('tipo',['grupos','catequistas','documentos'])->name('catalogos.index');
 Route::post('/catalogos/{tipo}',[CatalogoController::class,'store'])->whereIn('tipo',['grupos','catequistas','documentos'])->name('catalogos.store');
 Route::put('/catalogos/{tipo}/{id}',[CatalogoController::class,'update'])->whereIn('tipo',['grupos','catequistas','documentos'])->name('catalogos.update');
 Route::delete('/catalogos/{tipo}/{id}',[CatalogoController::class,'destroy'])->whereIn('tipo',['grupos','catequistas','documentos'])->name('catalogos.destroy');
 Route::get('/usuarios',[UsuarioController::class,'index'])->name('usuarios.index');
 Route::post('/usuarios',[UsuarioController::class,'store'])->name('usuarios.store');
 Route::delete('/usuarios/{usuario}',[UsuarioController::class,'destroy'])->name('usuarios.destroy');
});
