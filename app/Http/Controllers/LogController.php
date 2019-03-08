<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class LogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $logs = \App\Log::all();
        return response([ "success" => TRUE, "data" => $logs ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
    
            $params = request()->only(['deviceID', 'events']);
            extract($params);
    
            $device = \App\Device::where("device_id", $deviceID)->first();
            if(! $device)
                return response( ["success" => FALSE, "message" => "Device not found, please register devices first." ], 404);
            
            foreach($events as $key => $obj){
                
                \App\Log::create([
                                "device_id" => $deviceID,
                                "event"     => '{ "name": "' . $obj['name'] . '", "actions": ' . json_encode($obj) . ' }'
                            ]);
            }
            return response( ["success" => TRUE, "message" => "Events were logged successfully." ], 200);
        
        }catch (\Exception $e){

            return response( ["success" => FALSE, "message" => "Something happened! Please check your parameters and try again" ], 500);
        }
    
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeEvent(Request $request)
    {
        try{
    
            $params = request()->only(['deviceID', 'events']);
            extract($params);
    
            $device = \App\Device::where("device_id", $deviceID)->first();
            if(! $device)
                return response( ["success" => FALSE, "message" => "Device not found, please register devices first." ], 404);
            
            foreach($events as $key => $obj){
    
                \App\Log::create([
                                "device_id" => $deviceID,
                                "event"     => '{ "name": "' . $key . '", "actions": ' . json_encode($obj) . ' }'
                            ]);
            }
            return response( ["success" => TRUE, "message" => "Events were logged successfully." ], 200);
        
        }catch (\Exception $e){

            return response( ["success" => FALSE, "message" => "Something happened! Please check your parameters and try again" ], 500);
        }
    
    }

    /**
     * csv report
     *
     * @return \Illuminate\Http\Response
     */
    public function report()
    {
        $headers = ["Fecha","Equipo","Nivel","Interacciones","Duración"];
        $store_param  = request()->get('store') && request()->get('store') !== "" ? request()->get('store') : NULL;
        $from    = request()->get('from') && request()->get('from') !== "" ? request()->get('from') : Carbon::now()->format('Y-m-d');
        $to      = request()->get('to') && request()->get('to') !== "" ? request()->get('to') : Carbon::now()->format('Y-m-d');
        $filename = "../storage/app/public/{$store_param}.csv";
        
        $full_log       = \App\Log::where('timestamp', '>', $from)
                                    ->where('timestamp', '<', $to)
                                    ->orderBy('timestamp', 'desc')
                                    ->groupBy('timestamp')
                                    ->take(999)->get();
                        
        $handle = fopen($filename, 'w+');
        fputcsv($handle, $headers);
    
        foreach($full_log as &$row) {
            $event = $row->event;
            $fake_array = [
                        "fecha" => $row->timestamp,
                        "equipo" => $row->device_id,
                        "nivel" => $event['actions']->name,
                        "interacciones" => $event['actions']->interaction,
                        "duracion" => $event['actions']->timeSpent
                ];
            fputcsv($handle, array_values($fake_array));
        }
        fclose($handle);
    
        $request_headers = array(
            'Content-Type' => 'text/csv',
        );
        return Response::download($filename, "{$store_param}-{$from}-{$to}.csv", $request_headers);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
