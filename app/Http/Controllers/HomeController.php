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
    public function index()
    {
        $log = \App\Log::all();
        $device_count = \App\Device::count();
        $store_count = \App\Store::count();
        $event_count = \App\Log::count();
        return view('home')->with(compact(['log', 'store_count', 'device_count', 'event_count']));
    }
}
