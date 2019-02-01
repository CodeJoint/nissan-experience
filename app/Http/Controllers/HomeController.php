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
        
        $full_log       = \App\Log::orderBy('timestamp', 'desc')->take(10)->get();
        $event_count    = \App\Log::count();
        $devices        = \App\Device::all('device_id');
        foreach ($devices as $device){
            $echo = $device->store()->first();
            $echo = $device;
        }
        $devices_array  = [];
        foreach ($devices as $device_id){
            $devices_array[] = $device_id->device_id;
        }
        $device_count   = $devices->count();
        $active_device_count   = \App\Device::whereHas('logs', function ($query) use( $devices_array ) {
                                    $query->where('device_id', 'IN', $devices_array);
                                });
        $stores         = \App\Store::all(['name','identifier']);
        $store_count    = \App\Store::count();
        return view('home')->with(compact(['full_log', 'stores', 'store_count', 'device_count', 'active_device_count', 'event_count']));
    }
    
}
