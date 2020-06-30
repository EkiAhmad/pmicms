<?php

namespace App\Model\Master;

use Illuminate\Database\Eloquent\Model;

class ProdukDarah extends Model
{
    //protected $connection = 'connection-name'; //jika menggunakan 2 DB modelnya harus dikasih ini
    protected $primaryKey = 'produk_id'; // set primarykeymu jika bukan ID
    protected $table = 'master_produk_darah';
    protected $fillable = ['produk_name', 'produk_description'];
    //public $incrementing = false; //jika primary keynya string
    //public $timestamps = false; //matiin created_at, updated_at
}
