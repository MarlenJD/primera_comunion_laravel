<?php
namespace App\Http\Controllers;
use App\Models\{Aspirante,Tutor,Grupo,Documento};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
class AspiranteController extends Controller {
 private function canWrite(): void {if(!in_array(auth()->user()->rol,['administrador','encargado','coordinador'])) abort(403);}
 public function index(Request $r){$q=Aspirante::with(['tutor','grupo']);if($r->filled('buscar'))$q->where('nombre','like','%'.$r->buscar.'%');if(in_array($r->estado,['pendiente','en_revision','confirmada']))$q->where('estado',$r->estado);return view('aspirantes.index',['items'=>$q->latest()->paginate(12)->withQueryString()]);}
 private function formData(){return ['grupos'=>Grupo::orderBy('nombre')->get(),'documentos'=>Documento::orderBy('nombre')->get()];}
 public function create(){ $this->canWrite();return view('aspirantes.form',$this->formData()+['item'=>new Aspirante()]);}
 public function edit(Aspirante $aspirante){$this->canWrite();$aspirante->load(['tutor','documentos']);return view('aspirantes.form',$this->formData()+['item'=>$aspirante]);}
 private function validated(Request $r,?Aspirante $item=null){$data=$r->validate(['nombre'=>'required|string|max:150','fecha_nacimiento'=>'required|date|before_or_equal:today','domicilio'=>'required|string|max:255','bautismo'=>'nullable|string|max:255','observaciones'=>'nullable|string|max:2000','grupo_id'=>'nullable|exists:grupos,id','tutor_nombre'=>'required|string|max:150','parentesco'=>'required|in:padre,madre,tutor','telefono'=>'required|string|max:30','tutor_domicilio'=>'nullable|string|max:255','documentos'=>'array','documentos.*'=>'exists:documentos,id']);
 $duplicado=Aspirante::where('nombre',$data['nombre'])->whereDate('fecha_nacimiento',$data['fecha_nacimiento'])->when($item,fn($q)=>$q->where('id','!=',$item->id))->exists();if($duplicado)throw ValidationException::withMessages(['nombre'=>'Posible duplicado: ya existe un aspirante con este nombre y fecha de nacimiento.']);return $data;}
 private function save(Request $r,?Aspirante $item=null){$this->canWrite();$data=$this->validated($r,$item);DB::transaction(function()use($data,$item){$tutor=$item? $item->tutor : new Tutor();$tutor->fill(['nombre'=>$data['tutor_nombre'],'parentesco'=>$data['parentesco'],'telefono'=>$data['telefono'],'domicilio'=>$data['tutor_domicilio']??null])->save();$values=collect($data)->only(['nombre','fecha_nacimiento','domicilio','bautismo','observaciones','grupo_id'])->all();$values['tutor_id']=$tutor->id;if(!$item){$values['fecha_inscripcion']=today();$values['registrado_por']=auth()->id();$item=Aspirante::create($values);}else{$item->update($values);} $ids=$data['documentos']??[];$sync=[];foreach($ids as $id){$old=$item->documentos()->where('documentos.id',$id)->first();$sync[$id]=['fecha_entrega'=>$old?->pivot?->fecha_entrega??today()->toDateString()];}$item->documentos()->sync($sync);});return redirect()->route('aspirantes.index')->with('ok','Aspirante guardado correctamente.');}
 public function store(Request $r){return $this->save($r);}
 public function update(Request $r,Aspirante $aspirante){return $this->save($r,$aspirante);}
 public function show(Aspirante $aspirante){$aspirante->load(['tutor','grupo.catequista','documentos']);return view('aspirantes.show',['item'=>$aspirante,'documentos'=>Documento::all()]);}
 public function estado(Request $r,Aspirante $aspirante){$this->canWrite();$data=$r->validate(['estado'=>'required|in:pendiente,en_revision,confirmada']);if($data['estado']==='confirmada'){$obligatorios=Documento::where('obligatorio',true)->pluck('id');$entregados=$aspirante->documentos()->pluck('documentos.id');if($obligatorios->diff($entregados)->isNotEmpty())return back()->withErrors(['estado'=>'No se puede confirmar: faltan documentos obligatorios.']);} $aspirante->update($data);return back()->with('ok','Estado actualizado.');}
 public function destroy(Aspirante $aspirante){$this->canWrite();DB::transaction(function()use($aspirante){$tutor=$aspirante->tutor;$aspirante->delete();if($tutor && !$tutor->aspirantes()->exists())$tutor->delete();});return redirect()->route('aspirantes.index')->with('ok','Aspirante eliminado.');}
 //public function reporte(Request $r){$items=Aspirante::with(['tutor','grupo'])->orderBy('nombre')->get();return response()->streamDownload(function()use($items){$out=fopen('php://output','w');fwrite($out,"ï»¿");fputcsv($out,['Nombre','Nacimiento','Tutor','Teléfono','Grupo','Estado','Inscripción']);foreach($items as $a)fputcsv($out,[$a->nombre,$a->fecha_nacimiento,$a->tutor?->nombre,$a->tutor?->telefono,$a->grupo?->nombre,$a->estado,$a->fecha_inscripcion]);fclose($out);},'aspirantes.csv',['Content-Type'=>'text/csv; charset=UTF-8']);}

public function reporte(Request $request)
{
    if (auth()->user()->rol === 'catequista') {
        abort(403, 'No tienes permiso para descargar este reporte.');
    }

    $aspirantes = \App\Models\Aspirante::with([
        'tutor',
        'grupo.catequista'
    ])
    ->orderBy('nombre')
    ->get();

    $nombreArchivo = 'reporte_aspirantes_' . date('Y-m-d_H-i-s') . '.csv';

    $callback = function () use ($aspirantes) {

        $archivo = fopen('php://output', 'w');

        fwrite($archivo, "\xEF\xBB\xBF");

        fputcsv($archivo, [
            'ID',
            'Nombre del aspirante',
            'Fecha de nacimiento',
            'Domicilio',
            'Bautismo',
            'Nombre del tutor',
            'Parentesco',
            'Telefono',
            'Grupo',
            'Horario',
            'Lugar',
            'Catequista',
            'Fecha de inscripcion',
            'Estado',
            'Observaciones'
        ]);

        foreach ($aspirantes as $aspirante) {

            fputcsv($archivo, [
                $aspirante->id,
                $aspirante->nombre,
                $aspirante->fecha_nacimiento,
                $aspirante->domicilio,
                $aspirante->bautismo,
                $aspirante->tutor?->nombre ?? '',
                $aspirante->tutor?->parentesco ?? '',
                $aspirante->tutor?->telefono ?? '',
                $aspirante->grupo?->nombre ?? '',
                $aspirante->grupo?->horario ?? '',
                $aspirante->grupo?->lugar ?? '',
                $aspirante->grupo?->catequista?->nombre ?? '',
                $aspirante->fecha_inscripcion,
                ucfirst(str_replace('_', ' ', $aspirante->estado)),
                $aspirante->observaciones
            ], ';');
        }

        fclose($archivo);
    };

    return response()->streamDownload(
        $callback,
        $nombreArchivo,
        [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Cache-Control' => 'no-store, no-cache',
            'Content-Disposition' => 'attachment'
        ]
    );
}

 }
