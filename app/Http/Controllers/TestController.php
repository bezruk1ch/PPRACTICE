<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index()
    {
        return view('layouts.pages.test'); // или любое имя твоего Blade-шаблона
    }
}
