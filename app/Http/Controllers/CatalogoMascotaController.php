<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CatalogoMascotaController extends Controller
{
    public function index()
    {
        return view('Catalogo.index');
    }
}