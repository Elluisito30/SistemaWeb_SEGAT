<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GerenteController extends Controller
{
    public function dashboard()
    {
        return view('mantenedor.vistasHome.homeGerente');
    }
}