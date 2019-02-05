<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    protected $table = 'devices';
    public $timestamps = false;
    
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'device_id', 'store_id', 'comment'
    ];
    
    /**
     * Fetch logs associated with this device
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function logs(){
        return $this->hasMany(\App\Log::class, 'device_id','device_id');
    }
    
    /**
     * Fetch the store that owns this device
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function store(){
        return $this->belongsTo(\App\Store::class, 'store_id','id');
    }
    
}
