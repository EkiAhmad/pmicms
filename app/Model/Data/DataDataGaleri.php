<?php

namespace App\Model\Data;

use Illuminate\Database\Eloquent\Model;

class DataDataGaleri extends Model
{
    //protected $connection = 'connection-name'; //jika menggunakan 2 DB modelnya harus dikasih ini
    protected $primaryKey = 'galeri_id'; // set primarykeymu jika bukan ID
    protected $table = 'data_galeri';
    protected $fillable = [
        'kegiatan_id',
        'galeri_location',
        'created_by',
        'updated_by',
    ];
    //public $incrementing = false; //jika primary keynya string
    //public $timestamps = false; //matiin created_at, updated_at

    public function kegiatan()
    {
        return $this->hasMany('App\Model\Data\DataKegiatan', 'kegiatan_id', 'kegiatan_id');
    }
}
