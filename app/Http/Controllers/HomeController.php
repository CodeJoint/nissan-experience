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
        $chart_final    = [
            "interaction" => [
                "labels" => [],
                "values" => []
            ]
        ];
        $storeObject    = NULL;
        $session_length  = 0;

        Carbon::setLocale('es_MX');

        $store_param  = request()->get('store') && request()->get('store') !== "" ? request()->get('store') : NULL;
        $from    = request()->get('from') && request()->get('from') !== "" ? request()->get('from') : Carbon::now()->day(1)->format('Y-m-d');
        $to      = request()->get('to') && request()->get('to') !== "" ? request()->get('to') : Carbon::now()->format('Y-m-d');
       
        if($store_param){
            $storeObject    = \App\Store::where('identifier', $store_param)->first();
            if(!$storeObject)
                abort(404);
            $devices  = \App\Device::where('store_id', $storeObject['id'])
                                            ->get();
        }else{
            $devices  = \App\Device::all();
        }
    
        $full_log       = \App\Log::where('timestamp', '>', $from)
                                    ->where('timestamp', '<', $to)
                                    ->when($store_param, function($q){
//                                        $q->where();
                                    })
                                    ->orderBy('timestamp', 'desc')
                                    ->groupBy('timestamp')
                                    ->take(999)->get();
            $logArray  = $full_log->toArray();
            array_walk($logArray, function(&$element1, $key) use($session_length){
                $session_length += $element1->event['actions']->timeSpent;
            });
            
            $event_count    = $full_log->count();
            
        if($session_length && $event_count)
            $session_length = $session_length/$event_count;
        
        $device_count   = $devices->count();
        $active_device_count   = \App\Device::whereHas('logs')->count();
        
        $stores         = \App\Store::all(['name','identifier']);
        
        foreach ($stores as $index => $myStore){
            
            $chart_final['interaction']['labels'][] = $myStore->name;
            $laStore = \App\Store::where('identifier', $myStore->identifier)->first();
            $devices = $laStore->devices()->get();
            $devices_ids = array_column($devices->toArray(), 'device_id');
            
            $internal_logs = \App\Log::when(!empty($devices_ids), function($q) use ($devices_ids){
                                            $q->whereIn('device_id', $devices_ids);
                                        })
                                        ->where('timestamp', '>', $from)
                                        ->where('timestamp', '<', $to)
                                        ->orderBy('timestamp', 'desc')
                                        ->groupBy('timestamp')
                                        ->take(9999)->get(['event']);
            
            $leArray = array_column($internal_logs->toArray(), 'event');
            array_walk($leArray, function(&$element) use (&$chart_final, $index){
                $chart_final['interaction']['values'][$index] += $element['actions']->interaction;
            });

        }

        if($devices->isEmpty()){
            $notifications[] = "No se ha registrado ningún dispositivo en esta tienda.";
            $notifications[] = "Aún no se reciben eventos";
        }else{
            $notifications[] = "Se han registrado ".count($devices)." dispositivos en tiendas.";
            $notifications[] = "La sección con mayor interacción es: playContinuo";
            $notifications[] = "Se han recibido un total de {$event_count} eventos de {$from} a {$to}";
        }
        
        return view('home')->with(compact(['from','to','session_length','full_log', 'storeObject', 'stores', 'device_count', 'devices', 'active_device_count', 'event_count', 'notifications', 'chart_final']));
    }
    
}
