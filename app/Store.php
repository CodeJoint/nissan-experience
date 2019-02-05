<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    protected $table = 'stores';
    public $timestamps = false;
    
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'identifier'
    ];
    
    /**
     * Fetch the devices associated with this store
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function devices(){
        return $this->hasMany(\App\Device::class, 'store_id', 'id');
    }
    
}
