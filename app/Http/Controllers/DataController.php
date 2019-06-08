<?php

namespace App\Http\Controllers;

use App\Models\Config\Escuela;
use App\Models\Config\Ciclo;
use App\Models\Config\Grado;
use Yajra\DataTables\DataTables;

class DataController extends Controller
{

    public function escuelas(){
        $escuelas = Escuela::with('nivel')->orderBy('created_at','desc')->get();
        return DataTables::of($escuelas)
            ->addColumn('actions', function ($escuela) {
                $showUrl = route('escuelas.show',['id' => $escuela->id]);
                $editUrl = route('escuelas.edit',['id' => $escuela->id]);
                $deleteUrl = route('escuelas.destroy',['id' => $escuela->id]);
                return view('_formActions', compact('showUrl','editUrl','deleteUrl'));
            })
            ->make(true);
    }

    public function ciclos(){
        $ciclos = Ciclo::orderBy('periodo','desc')->get();
        return DataTables::of($ciclos)
            ->addColumn('actions', function($ciclo){
                $showUrl = route('ciclos.show',['id' => $ciclo->id]);
                $editUrl = route('ciclos.edit',['id' => $ciclo->id]);
                $deleteUrl = route('ciclos.destroy',['id' => $ciclo->id]);
                return view('_formActions', compact('showUrl','editUrl','deleteUrl'));
            })
            ->make(true);
    }

    public function grados($escuela,$ciclo){
        $grados = Grado::where('escuela_id',$escuela)
                    ->where('ciclo_id',$ciclo)
                    ->orderBy('id','asc')
                    ->get();
        return DataTables::of($grados)
            ->addColumn('actions', function($grado){
                $showUrl = route('grados.show',['id' => $grado->id]);
                $editUrl = route('grados.edit',['id' => $grado->id]);
                $deleteUrl = route('grados.destroy',['id' => $grado->id]);
                return view('_formActions', compact('showUrl','editUrl','deleteUrl'));
            })
            ->make(true);
    }
}
