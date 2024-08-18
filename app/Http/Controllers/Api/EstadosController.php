<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Estado;
use Illuminate\Http\Request;

class EstadosController extends Controller
{
    public function index(Request $request)
    {
        $cidades = Estado::orderBy('nome');

        if($request->filled('search')) {
            $cidades->where(function($query) use ($request) {
                if($request->filled('column')) {
                    if($request->column == 'uf') {
                        $query->where('uf', $request->search);
                    }else{
                        $query->where('nome', 'like', $request->search.'%');
                    }
                }else{
                    $query->whereAny(['nome', 'uf'], 'like', $request->search.'%');
                }
            });
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
        return Estado::find($id);
    }
}
