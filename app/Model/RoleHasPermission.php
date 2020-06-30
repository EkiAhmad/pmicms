<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class RoleHasPermission extends Model
{
    //protected $connection = 'connection-name'; //jika menggunakan 2 DB modelnya harus dikasih ini
    protected $table = 'role_has_permissions';
    protected $fillable = ['permission_id', 'role_id'];
    public $incrementing = false; //jika primary keynya string
    public $timestamps = false; //matiin created_at, updated_at
}
