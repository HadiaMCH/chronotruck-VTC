<?php

namespace App\Http\Controllers;

use App\Models\presentation;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Http\Controllers\Views\presentationView;

class presentationController extends Controller
{
    public function index()
    {        
        $presentation=presentation::first();

        return (new presentationView)->presentation($presentation);

    }
}
