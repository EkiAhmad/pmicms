<?php

namespace App\Model\JekDon;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //protected $connection = 'connection-name'; //jika menggunakan 2 DB modelnya harus dikasih ini
    protected $primaryKey = 'order_id'; // set primarykeymu jika bukan ID
    protected $table = 'data_order';
    protected $fillable = [
        'order_driver_id',
        'order_rs_id',
        'order_code',
        'order_number',
        'order_status',
        'order_tujuan',
        'order_telepon',
        'order_description',
        'created_by'
    ];
    //public $incrementing = false; //jika primary keynya string
    //public $timestamps = false; //matiin created_at, updated_at

    public function rumah_sakit(){
        
        return $this->belongsTo('App\Model\Master\RumahSakit', 'order_rs_id', 'rs_id'); 

    }

    public function driver(){
        
        return $this->belongsTo('App\Model\Master\UserDriver', 'order_driver_id', 'driver_id'); 
        

    }

    
}
