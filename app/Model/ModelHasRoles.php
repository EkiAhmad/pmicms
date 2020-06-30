<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ModelHasRoles extends Model
{
    //protected $connection = 'connection-name'; //jika menggunakan 2 DB modelnya harus dikasih ini
    //protected $primaryKey = 'your_key_name'; // set primarykeymu jika bukan ID
    protected $table = 'model_has_roles';
    protected $fillable = [];
    //public $incrementing = false; //jika primary keynya string
    //public $timestamps = false; //matiin created_at, updated_at
}
