<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ComoNosEncontrou;

class ComoNosEncontrouController extends Controller
{
    //
    public function index()
    {
        $comoNosEncontrou = ComoNosEncontrou::orderBy('created_at', 'desc')
            ->paginate(10);

        


        return view('como-nos-encontrou.index', compact('comoNosEncontrou'));
    }
}
