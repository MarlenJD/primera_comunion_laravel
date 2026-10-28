<?php
namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
class UsuarioController extends Controller {
 private function gate(){if(auth()->user()->rol!=='administrador')abort(403);}
 public function index(){ $this->gate();return view('usuarios.index',['items'=>User::orderBy('name')->get()]);}
 public function store(Request $r){$this->gate();$d=$r->validate(['name'=>'required|string|max:150','email'=>'required|email|unique:users,email','password'=>'required|string|min:10','rol'=>'required|in:administrador,encargado,coordinador,catequista']);$d['password']=Hash::make($d['password']);User::create($d);return back()->with('ok','Usuario creado.');}
 public function destroy(User $usuario){$this->gate();if($usuario->id===auth()->id())return back()->withErrors(['error'=>'No puedes eliminar tu propia cuenta.']);if($usuario->rol==='administrador'&&User::where('rol','administrador')->count()<=1)return back()->withErrors(['error'=>'Debe existir un administrador.']);$usuario->delete();return back()->with('ok','Usuario eliminado.');}
}
