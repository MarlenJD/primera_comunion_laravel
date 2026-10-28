<?php
namespace App\Http\Controllers;
use App\Models\{Aspirante,Grupo,Catequista,Documento};
class DashboardController extends Controller {public function index(){return view('dashboard',['total'=>Aspirante::count(),'pendientes'=>Aspirante::where('estado','pendiente')->count(),'confirmadas'=>Aspirante::where('estado','confirmada')->count(),'grupos'=>Grupo::count(),'catequistas'=>Catequista::count(),'documentos'=>Documento::count(),'recientes'=>Aspirante::with('grupo')->latest()->limit(8)->get()]);}}
