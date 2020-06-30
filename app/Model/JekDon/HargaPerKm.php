<?php

namespace App\Model\JekDon;

use Illuminate\Database\Eloquent\Model;

class HargaPerKm extends Model
{
    //protected $connection = 'connection-name'; //jika menggunakan 2 DB modelnya harus dikasih ini
    protected $primaryKey = 'harga_id'; // set primarykeymu jika bukan ID
    protected $table = 'master_harga_km';
    protected $fillable = [
        'harga_perkm'
    ];
    //public $incrementing = false; //jika primary keynya string
    //public $timestamps = false; //matiin created_at, updated_at
}
