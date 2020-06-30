<?php

namespace App\Model\Data;

use Illuminate\Database\Eloquent\Model;

class DataStockDarah extends Model
{
    //protected $connection = 'connection-name'; //jika menggunakan 2 DB modelnya harus dikasih ini
    protected $primaryKey = 'stock_id'; // set primarykeymu jika bukan ID
    protected $table = 'data_stock';
    protected $fillable = [
        'stock_golongan_darah_id',
        'stock_produk_darah_id',
        'stock_jumlah',
        'stock_show',
        'created_by',
        'updated_by',
    ];
    //public $incrementing = false; //jika primary keynya string
    //public $timestamps = false; //matiin created_at, updated_at

    public function golongan_darah()
    {
        return $this->hasMany('App\Model\Master\GolonganDarah', 'golongan_id', 'stock_golongan_darah_id');
    }

    public function produk_darah()
    {
        return $this->hasMany('App\Model\Master\ProdukDarah', 'produk_id', 'stock_produk_darah_id');
    }
}
