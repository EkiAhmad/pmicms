<?php

namespace App\Model\Notify;

use Illuminate\Database\Eloquent\Model;

class Notify extends Model
{
    //protected $connection = 'connection-name'; //jika menggunakan 2 DB modelnya harus dikasih ini
    protected $primaryKey = 'data_notify_id'; // set primarykeymu jika bukan ID
    protected $table = 'data_notify';
    protected $fillable = [
        'data_notify_judul', 
        'data_notify_content',
        'created_by',
        'updated_by'
    ];
    //public $incrementing = false; //jika primary keynya string
    // public $timestamps = false; //matiin created_at, updated_at
}
