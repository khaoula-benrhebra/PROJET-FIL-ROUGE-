<?php

namespace App\Http\Controllers\Gerant; 
use App\Http\Controllers\Controller; 
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
{
    return view('pages.gerant.menu');
}

public function create()
{
    return view('gerant.create-menu-item');
}

public function edit($id)
{
    return view('gerant.edit-menu-item');
}
}