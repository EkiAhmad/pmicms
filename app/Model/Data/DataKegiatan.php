<?php

namespace App\Model\Data;

use Illuminate\Database\Eloquent\Model;

class DataKegiatan extends Model
{
    //protected $connection = 'connection-name'; //jika menggunakan 2 DB modelnya harus dikasih ini
    protected $primaryKey = 'kegiatan_id'; // set primarykeymu jika bukan ID
    protected $table = 'data_kegiatan';
    protected $fillable = [
        'kegiatan_title',
        'tgl_mulai',
        'tgl_selesai',
        'kegiatan_content',
        'kegiatan_type',
        'lat',
        'lng',
        'lokasi',
        'kegiatan_image',
        'kegiatan_estimasi',
        'kegiatan_status',
        'created_by',
        'updated_by',
    ];
    //public $incrementing = false; //jika primary keynya string
    //public $timestamps = false; //matiin created_at, updated_at
}
