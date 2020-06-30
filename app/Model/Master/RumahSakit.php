<?php

namespace App\Model\Master;

use Illuminate\Database\Eloquent\Model;

class RumahSakit extends Model
{
    //protected $connection = 'connection-name'; //jika menggunakan 2 DB modelnya harus dikasih ini
    protected $primaryKey = 'rs_id'; // set primarykeymu jika bukan ID
    protected $table = 'master_rs';
    protected $fillable = ['rs_name', 'rs_description', 'rs_address'];
    //public $incrementing = false; //jika primary keynya string
    //public $timestamps = false; //matiin created_at, updated_at

    public function jekdon_order(){
        
        return $this->belongsTo('App\Model\Master\RumahSakit', 'rs_id', 'order_rs_id'); 

    }
}
