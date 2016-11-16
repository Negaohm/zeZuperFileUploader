<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth",["except"=>["welcome"]]);
    }
    public function welcome(Request $request)
    {
        return view("welcome");
    }
    public function home(Request $request)
    {
        return view("home",["user"=>Auth::user()]);
    }
}
