<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DeviceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $all_devices = \App\Device::all();
        return response( ["success" => TRUE, "data" => $all_devices ], 200);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexStores()
    {
        $all_stores = \App\Store::all();
        return response( ["success" => TRUE, "data" => $all_stores ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        
        $request_params = request()->only(['deviceID', 'store', 'comment']);
        // Check if store exists
        $myStore = \App\Store::where("identifier", $request_params['store'])->first();
        $myDevice = \App\Device::where("device_id", $request_params['deviceID'])->count();

        if(! $myStore)
            return response( ["success" => FALSE, "message" => "No valid store found with the identifier: " . $request_params['store'] ], 404);
        
        if($myDevice > 0)
            return response( ["success" => FALSE, "message" => "Device {$request_params['store']} already registered"  ], 404);

        // Create device and associate with store
        try{

            DB::transaction(function () use ( $request_params, $myStore ) {

                \App\Device::create([
                                "device_id" => $request_params['deviceID'],
                                "store_id"  => $myStore['id'],
                                "comment"   => !empty($request_params['comment']) ? $request_params['comment'] : NULL
                            ]);
            });
            return response( ["success" => TRUE, "message" => "Resource created successfully." ], 200);

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
    public function createStore(Request $request)
    {
        
        try{
        
            $request_params = request()->only(['name', 'store']);
            DB::transaction(function () use ( $request_params ) {
    
                \App\Store::create([
                    "name" => $request_params['name'],
                    "identifier" => $request_params['store']
                ]);
    
    
            });
            return response( ["success" => TRUE, "message" => "Resource created successfully." ], 200);
        
        }catch (\Exception $e){
        
            return response( ["success" => FALSE, "message" => "Something happened while creating resource." ], 500);
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
