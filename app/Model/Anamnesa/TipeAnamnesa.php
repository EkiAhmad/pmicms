<?php

namespace App\Model\Anamnesa;

use Illuminate\Database\Eloquent\Model;

class TipeAnamnesa extends Model
{
    //protected $connection = 'connection-name'; //jika menggunakan 2 DB modelnya harus dikasih ini
    protected $primaryKey = 'tipe_id'; // set primarykeymu jika bukan ID
    protected $table = 'master_amenesa_tipe';
    protected $fillable = ['tipe_name', 'tipe_description', 'created_by', 'updated_by'];
    //public $incrementing = false; //jika primary keynya string
    //public $timestamps = false; //matiin created_at, updated_at

    public function pertanyaan()
    {
    	return $this->belongsTo('App\Model\Anamnesa\PertanyaanAnamnesa', 'pertanyaan_tipe_id', 'tipe_id');
    }
}
