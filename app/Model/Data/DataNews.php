<?php

namespace App\Model\Data;

use Illuminate\Database\Eloquent\Model;

class DataNews extends Model
{
    //protected $connection = 'connection-name'; //jika menggunakan 2 DB modelnya harus dikasih ini
    protected $primaryKey = 'news_id'; // set primarykeymu jika bukan ID
    protected $table = 'data_news';
    protected $fillable = [
        'news_title',
        'news_content',
        'news_image',
        'news_author_id',
        'news_type',
        'news_category_id',
        'created_by',
        'updated_by',
    ];
    //public $incrementing = false; //jika primary keynya string
    //public $timestamps = false; //matiin created_at, updated_at

    public function user()
    {
        return $this->hasMany('App\User', 'user_id', 'news_author_id');
    }

    public function category()
    {
        return $this->hasMany('App\Model\Master\NewsCategory', 'category_id', 'news_category_id');
    }
}
