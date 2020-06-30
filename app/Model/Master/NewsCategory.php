<?php

namespace App\Model\Master;

use Illuminate\Database\Eloquent\Model;

class NewsCategory extends Model
{
    //protected $connection = 'connection-name'; //jika menggunakan 2 DB modelnya harus dikasih ini
    protected $primaryKey = 'category_id'; // set primarykeymu jika bukan ID
    protected $table = 'master_news_category';
    protected $fillable = ['category_name', 'category_description', 'created_by', 'updated_by'];
    //public $incrementing = false; //jika primary keynya string
    //public $timestamps = false; //matiin created_at, updated_at
}
