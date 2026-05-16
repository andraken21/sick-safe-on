<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApotekerController extends Controller
{
    public function dashboard()
    {
        return view('apoteker.dashboard2');
    }
}