<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tenant\Moradores;
use Illuminate\Http\Request;

class MoradoresController extends Controller
{
    public function index(Request $request)
    {
        $moradores = Moradores::orderBy('nome');

        if($request->filled('search')) {
            $moradores->where(function($query) use ($request) {
                $query->where('nome', 'like', $request->search.'%');
                $query->orWhere('sobrenome', 'like', $request->search.'%');
            });
        }

        if($request->filled('selected')) {
            $moradores->whereIn('id', $request->input('selected', []));
        }

        if($request->filled('ignore'))  {
            $moradores->whereNotIn('id', $request->input('ignore', []));
        }

        if($request->filled('empresa')) $moradores->withTenant(1, $request->get('empresa'));

        $moradores->select('*')->selectRaw("CONCAT(nome, ' ', sobrenome) as nome_completo");

        return $moradores->limit(50)->get();
    }

    public function show(string $id)
    {
        return Moradores::find($id);
    }
}
