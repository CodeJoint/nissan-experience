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
        $full_log = \App\Log::all();
        $event_count    = \App\Log::count();
        $devices        = \App\Device::all('device_id');
        $devices_values = array_values($devices->toArray());
        $device_count   = $devices->count();
        $active_device_count   = \App\Device::whereHas('logs', function ($query) use($devices) {
                                    $query->where('device_id', 'IN', array_values($devices->toArray()));
                                })->count();
        $store_count    = \App\Store::count();
        return view('home')->with(compact(['full_log', 'store_count', 'device_count', 'event_count']));
    }
}
