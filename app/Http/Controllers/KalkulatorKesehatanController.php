<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KalkulatorKesehatanController extends Controller
{
    public function index()
    {
        return view('masyarakat.kalkulator.index');
    }
}
