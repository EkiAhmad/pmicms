<?php

namespace App\Model\Master;

use Illuminate\Database\Eloquent\Model;

class UserDriver extends Model
{
    //protected $connection = 'connection-name'; //jika menggunakan 2 DB modelnya harus dikasih ini
    protected $primaryKey = 'driver_id'; // set primarykeymu jika bukan ID
    protected $table = 'user_driver';
    protected $fillable = ['driver_nama', 'driver_password', 'driver_telp', 'driver_email', 'driver_status'];
    //public $incrementing = false; //jika primary keynya string
    //public $timestamps = false; //matiin created_at, updated_at

    public function jekdon_order(){
        
        return $this->belongsTo('App\Model\Master\Order', 'driver_id', 'order_driver_id'); 
        

    }
}
