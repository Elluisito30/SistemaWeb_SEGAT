<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TrabajadorController extends Controller
{
    public function dashboard()
    {
        return view('vistasHome.homeTrabajador');
    }
}