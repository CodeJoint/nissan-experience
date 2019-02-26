<?php

namespace App\Http\Controllers;

use Carbon\Carbon;

class HomeController extends Controller
{
    private $factory = NULL;
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
        $notifications  = [];
        $devices_array  = [];
        $storeObject    = NULL;
        $session_length  = 0;

        Carbon::setLocale('es_MX');

        $store_param  = request()->get('store') && request()->get('store') !== "" ? request()->get('store') : NULL;
        $from    = request()->get('from') && request()->get('from') !== "" ? request()->get('from') : Carbon::now()->format('Y-m-d');
        $to      = request()->get('to') && request()->get('to') !== "" ? request()->get('to') : Carbon::now()->format('Y-m-d');
        $full_log       = \App\Log::where('timestamp', '>', $from)
                                    ->where('timestamp', '<', $to)
                                    ->orderBy('timestamp', 'desc')
                                    ->groupBy('timestamp')
                                    ->take(999)->get();
            $event_count    = $full_log->count();
        if($store_param){
            $storeObject    = \App\Store::where('identifier', $store_param)->first();
            if(!$storeObject)
                abort(404);
            $devices        = \App\Device::where('store_id', $storeObject)->get();
        }else{
            $devices        = \App\Device::all();
        }
     
        foreach ($devices as $myDevice){
//            $myLogs = $myDevice->logs()->get();
//            $myStore = $myDevice->store()->first();
            $devices_array[] = $myDevice->device_id;
        }
        foreach ($full_log as $log_entry){
//            $events = $log_entry->event;
//            $log_json = json_decode($log_entry->event['actions']->timeSpent, true);
            $session_length += $log_entry->event['actions']->timeSpent;
        }
        $session_length = $session_length/$event_count;
        $device_count   = $devices->count();
        $active_device_count   = \App\Device::whereHas('logs', function ($query) use( $devices_array ) {
//                                    $query->where('device_id', 'IN', $devices_array);
                                })->count();
        $stores         = \App\Store::all(['name','identifier']);
        $store_count    = \App\Store::count();
        if($devices->isEmpty()){
            $notifications[] = "No se ha registrado ningún dispositivo en esta tienda.";
            $notifications[] = "Aún no se reciben eventos";
        }else{
            $notifications[] = "Se han registrado ".count($devices)." dispositivos en {$store_count} tiendas.";
            $notifications[] = "La sección con mayor interacción es: playContinuo";
            $notifications[] = "Se han recibido un total de $event_count eventos";
        }
        return view('home')->with(compact(['from','to','session_length','full_log', 'storeObject', 'stores', 'store_count', 'device_count', 'devices', 'active_device_count', 'event_count', 'notifications']));
    }
    
}
