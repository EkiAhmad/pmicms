<?php

namespace App\Model\Anamnesa;

use Illuminate\Database\Eloquent\Model;

class PertanyaanAnamnesa extends Model
{
    //protected $connection = 'connection-name'; //jika menggunakan 2 DB modelnya harus dikasih ini
    protected $primaryKey = 'pertanyaan_id'; // set primarykeymu jika bukan ID
    protected $table = 'data_amenesa_pertanyaan';
    protected $fillable = ['pertanyaan_isi', 'pertanyaan_tipe_id', 'pertanyaan_kategori_id', 'pertanyaan_gender', 'created_by', 'updated_by'];
    //public $incrementing = false; //jika primary keynya string
    //public $timestamps = false; //matiin created_at, updated_at

    public function tipe()
    {
        return $this->belongsTo('App\Model\Anamnesa\TipeAnamnesa', 'pertanyaan_tipe_id', 'tipe_id');
    }

    public function kategori()
    {
        return $this->belongsTo('App\Model\Anamnesa\KategoriAnamnesa', 'pertanyaan_kategori_id', 'kategori_id');
    }
}
