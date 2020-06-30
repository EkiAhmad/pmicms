<?php

namespace App\Model\Anamnesa;

use Illuminate\Database\Eloquent\Model;

class KategoriAnamnesa extends Model
{
    //protected $connection = 'connection-name'; //jika menggunakan 2 DB modelnya harus dikasih ini
    protected $primaryKey = 'kategori_id'; // set primarykeymu jika bukan ID
    protected $table = 'master_amenesa_kategori';
    protected $fillable = ['kategori_judul', 'created_by', 'updated_by'];
    //public $incrementing = false; //jika primary keynya string
    //public $timestamps = false; //matiin created_at, updated_at

    public function pertanyaan()
    {
    	return $this->belongsTo('App\Model\Anamnesa\PertanyaanAnamnesa', 'pertanyaan_kategori_id', 'kategori_id');
    }
}
