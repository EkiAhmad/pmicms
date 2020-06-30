<?php

namespace App\Model\Master;

use Illuminate\Database\Eloquent\Model;

class MasterUdd extends Model
{
    //protected $connection = 'connection-name'; //jika menggunakan 2 DB modelnya harus dikasih ini
    //protected $primaryKey = 'your_key_name'; // set primarykeymu jika bukan ID
    protected $table = 'master_udd';
    protected $fillable = ['name', 'kode_udd'];
    //public $incrementing = false; //jika primary keynya string
    //public $timestamps = false; //matiin created_at, updated_at
}
