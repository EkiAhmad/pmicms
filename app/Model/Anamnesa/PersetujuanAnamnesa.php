<?php

namespace App\Model\Anamnesa;

use Illuminate\Database\Eloquent\Model;

class PersetujuanAnamnesa extends Model
{
    //protected $connection = 'connection-name'; //jika menggunakan 2 DB modelnya harus dikasih ini
    protected $primaryKey = 'persetujuan_id'; // set primarykeymu jika bukan ID
    protected $table = 'master_persetujuan';
    protected $fillable = ['persetujuan_content', 'persetujuan_tipe', 'persetujuan_created_by', 'persetujuan_updated_by', 'persetujuan_updated_at', 'persetujuan_created_at'];
    //public $incrementing = false; //jika primary keynya string
    public $timestamps = false; //matiin created_at, updated_at
}
