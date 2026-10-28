<?php
namespace App\Http\Controllers;
use App\Models\{Grupo,Catequista,Documento};
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
class CatalogoController extends Controller {
 private function config(string $tipo): array {return match($tipo){
 'grupos'=>[Grupo::class,'Grupos',['nombre'=>'required|string|max:150','horario'=>'nullable|string|max:150','lugar'=>'nullable|string|max:150','catequista_id'=>'nullable|exists:catequistas,id']],
 'catequistas'=>[Catequista::class,'Catequistas',['nombre'=>'required|string|max:150','telefono'=>'nullable|string|max:30','correo'=>'nullable|email|max:255']],
 'documentos'=>[Documento::class,'Documentos',['nombre'=>'required|string|max:150','obligatorio'=>'required|boolean']],
 default=>abort(404)};}
 private function gate(string $tipo): void {if(!in_array(auth()->user()->rol,['administrador','encargado','coordinador'])) abort(403);if($tipo==='documentos' && auth()->user()->rol!=='administrador') abort(403);}
 public function index(string $tipo){[$model,$titulo,$rules]=$this->config($tipo);$this->gate($tipo);return view('catalogos.index',compact('tipo','titulo','rules')+['items'=>$model::latest()->paginate(12),'catequistas'=>Catequista::orderBy('nombre')->get()]);}
 public function store(Request $r,string $tipo){[$model,$titulo,$rules]=$this->config($tipo);$this->gate($tipo);$data=$r->validate($rules);$model::create($data);return back()->with('ok','Registro creado.');}
 public function update(Request $r,string $tipo,int $id){[$model,$titulo,$rules]=$this->config($tipo);$this->gate($tipo);$item=$model::findOrFail($id);$item->update($r->validate($rules));return back()->with('ok','Registro actualizado.');}
 public function destroy(string $tipo,int $id){[$model]=$this->config($tipo);$this->gate($tipo);try{$model::findOrFail($id)->delete();}catch(\Illuminate\Database\QueryException $e){return back()->withErrors(['error'=>'No puede eliminarse porque tiene registros relacionados.']);}return back()->with('ok','Registro eliminado.');}
}
