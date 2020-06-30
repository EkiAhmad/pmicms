<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Title untuk judul di web
     * route digunakan untuk tempat resource (file path) + routing (route/web) diusahain sama ya biar gak ngubah"
     */
    private $title = 'Admin';
    private $route = 'admin.dashboard.'; //path awal foldernya ajah
    public function __construct()
    {
        DB::getQueryLog();
    }

    public function index()
    {
        $data = [
            //bawaan
            'title' => $this->title,
        ];
        return view($this->route . 'index', $data);
    }
}
