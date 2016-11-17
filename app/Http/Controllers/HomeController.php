<?php

namespace App\Http\Controllers;

use App\Image;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth",["except"=>["welcome"]]);
    }
    public function welcome(Request $request)
    {
        return view("welcome",['images'=>Image::where("created_at",">=",Carbon::today())->take(10)->get()]);
    }
    public function home(Request $request)
    {
        return view("home",["user"=>Auth::user(),'images'=>Image::where("created_at",">=",Carbon::today())->take(10)->get()]);
    }
}
