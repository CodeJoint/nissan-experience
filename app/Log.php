<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $table = 'logs';
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'device_id', 'event'
    ];
    
    /**
     * Fetch relationships
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function device(){
        return $this->belongsTo(\App\Device::class, 'device_id', 'device_id')->first();
    }
    
    /**
     *
     */
    public function getEventAttribute($event) {
        $event = json_decode($event);
        $formatted = [];
        foreach ($event as $key => $part){
            $formatted[$key] = $part;
        }
        return $formatted;
    }
    
}
