<?php

namespace App\Model\Master;

use Illuminate\Database\Eloquent\Model;

class GolonganDarah extends Model
{
    //protected $connection = 'connection-name'; //jika menggunakan 2 DB modelnya harus dikasih ini
    protected $primaryKey = 'golongan_id'; // set primarykeymu jika bukan ID
    protected $table = 'master_golongan_darah';
    protected $fillable = ['golongan_name', 'golongan_description'];
    //public $incrementing = false; //jika primary keynya string
    //public $timestamps = false; //matiin created_at, updated_at
}
