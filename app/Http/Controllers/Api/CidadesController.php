<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cidade;
use Illuminate\Http\Request;

class CidadesController extends Controller
{
    public function index(Request $request)
    {
        $cidades = Cidade::orderBy('nome');

        if(!$request->filled('selected')) {
            if(!$request->filled('estado')) {
                return [];
            }else{
                $cidades->where('estado_id', $request->estado);
            }
        }

        if($request->filled('search')) {
            $cidades->where('nome', 'like', $request->search.'%');
        }

        if($request->filled('selected')) {
            $cidades->whereIn('id', $request->input('selected', []));
        }

        if($request->filled('ignore'))  {
            $cidades->whereNotIn('id', $request->input('ignore', []));
        }

        return $cidades->limit(50)->get();
    }

    public function show(string $id)
    {
        return Cidade::find($id);
    }
}
