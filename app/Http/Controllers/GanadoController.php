<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GanadoController extends Controller
{
    public function index() {
        return view('ganado.index');
    }
}
