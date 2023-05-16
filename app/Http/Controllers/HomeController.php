<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        if($request->has('ymd')){
            $selected_date = $request->ymd;
        }elseif($request->has('ym')){
            $selected_date = $request->ym. '-01';
        }
        else{
            $selected_date = date('Y-m-d');
        }

        return view('home', ['selected_date' => $selected_date]);
    }
}
