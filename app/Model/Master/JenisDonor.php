<?php

namespace App\Model\Master;

use Illuminate\Database\Eloquent\Model;

class JenisDonor extends Model
{
    //protected $connection = 'connection-name'; //jika menggunakan 2 DB modelnya harus dikasih ini
    protected $primaryKey = 'jenis_id'; // set primarykeymu jika bukan ID
    protected $table = 'master_jenis_donor';
    protected $fillable = ['jenis_name', 'jenis_description'];
    //public $incrementing = false; //jika primary keynya string
    // public $timestamps = false; //matiin created_at, updated_at
}
