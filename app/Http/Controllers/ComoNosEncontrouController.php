<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ComoNosEncontrou;

class ComoNosEncontrouController extends Controller
{
    //
    public function index()
    {
        $user = Auth::user();
        if (!$user || !$user->hasRole('admin|moderador')) {
            return redirect()->route('associado.index')->with('error', 'Acesso negado. Você não tem permissão para acessar esta página.');
        }

        $comoNosEncontrou = ComoNosEncontrou::orderBy('created_at', 'desc')
            ->paginate(10);


        return view('como-nos-encontrou.index', compact('comoNosEncontrou'));
    }
}
