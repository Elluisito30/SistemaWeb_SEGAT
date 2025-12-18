<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CiudadanoController extends Controller
{
    public function dashboard()
    {
        return view('mantenedor.vistasHome.homeCiudadano');
    }
}