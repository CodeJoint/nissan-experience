<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
                                "event"     => '{ "name": "' . $key . '", "actions": ' . json_encode($obj) . ' }'
                            ]);
            }
            return response( ["success" => TRUE, "message" => "Events were logged successfully." ], 200);
        
        }catch (\Exception $e){

            return response( ["success" => FALSE, "message" => "Something happened! Please check your parameters and try again" ], 500);
        }
    
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
