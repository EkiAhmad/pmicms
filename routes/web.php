<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();
Route::get('/', function () {
    // return view('welcome');
    return redirect(route('auth.index'));
});
Route::get('logout', function () {
    Auth::logout();
    session()->flush();
    session()->invalidate();
    return Redirect::to(route('login'))->with('message', 'logout');
});


/**
 *  Login
 */
Route::group([
    'prefix'    => 'auth',
    'namespace' => 'Auth',
    'as'        => 'auth.',
], function () {

    Route::get('login', ['as' => 'index', 'uses' => 'LoginController@index']);
    Route::post('action-login', ['as' => 'action_login', 'uses' => 'LoginController@action_login']);
});
/**
 * route admin
 */
Route::group(
    [
        'middleware'    => ['auth_cek', 'auth'],
        'as'            => 'admin.',
        'namespace'     => 'Admin',
    ],
    function () {
        /**
         * Prefik admin.
         * Dashboard Controller
         */
        Route::get('dashboard', ['as' => 'dashboard', 'uses' => 'DashboardController@index']);

        /**
         * prefix admin.user_management.
         * user maangement
         */
        Route::group(
            [
                'prefix' => 'user-management',
                'as'     => 'user_management.',
                'namespace' => 'User_management'
            ],
            function () {
                /**
                 * prefix admin.user_management.role
                 * ROLE
                 */
                Route::group(
                    [
                        'prefix'    => 'role',
                        'as'        => 'role.',
                    ],
                    function () {
                        Route::get('/', ['as' => 'index', 'uses' => 'RoleController@index']);
                        Route::get('/create', ['as' => 'create', 'uses' => 'RoleController@create']);
                        Route::get('/update/{role_id}', ['as' => 'update', 'uses' => 'RoleController@update']);
                        Route::get('/delete-action/{role_id}', ['as' => 'delete_action', 'uses' => 'RoleController@delete_action']);

                        Route::post('/create-action', ['as' => 'create_action', 'uses' => 'RoleController@create_action']);
                        Route::post('/update-action', ['as' => 'update_action', 'uses' => 'RoleController@update_action']);
                    }
                );
                /**
                 * prefix admin.user_management.permission
                 * permission
                 */
                Route::group(
                    [
                        'prefix'    => 'permission',
                        'as'        => 'permission.',
                    ],
                    function () {
                        Route::get('/', ['as' => 'index', 'uses' => 'PermissionController@index']);
                        Route::get('/getdata', ['as' => 'getdata', 'uses' => 'PermissionController@getData']);
                        Route::get('/create', ['as' => 'create', 'uses' => 'PermissionController@create']);
                        Route::get('/update/{permission_id}', ['as' => 'update', 'uses' => 'PermissionController@update']);
                        Route::get('/delete-action/{permission_id}', ['as' => 'delete_action', 'uses' => 'PermissionController@delete_action']);

                        Route::post('/create-action', ['as' => 'create_action', 'uses' => 'PermissionController@create_action']);
                        Route::post('/update-action', ['as' => 'update_action', 'uses' => 'PermissionController@update_action']);
                    }
                );
                /**
                 * prefix admin.user_management.user
                 * user
                 */
                Route::group(
                    [
                        'prefix'    => 'user',
                        'as'        => 'user.',
                    ],
                    function () {
                        Route::get('/', ['as' => 'index', 'uses' => 'UserController@index']);
                        Route::get('/create', ['as' => 'create', 'uses' => 'UserController@create']);
                        Route::get('/update/{user_id}', ['as' => 'update', 'uses' => 'UserController@update']);
                        Route::get('/delete-action/{user_id}', ['as' => 'delete_action', 'uses' => 'UserController@delete_action']);

                        Route::post('/create-action', ['as' => 'create_action', 'uses' => 'UserController@create_action']);
                        Route::post('/update-action', ['as' => 'update_action', 'uses' => 'UserController@update_action']);
                    }
                );
            }
        );

        /**master */
        Route::group(
            [
                'prefix'    => 'master',
                'as'        => 'master.',
                'namespace' => 'Master'
            ],
            function () {
                /**
                 * prefix admin.master.udd
                 * user
                 */
                Route::group(
                    [
                        'prefix'    => 'udd',
                        'as'        => 'udd.',
                    ],
                    function () {
                        Route::get('/', ['as' => 'index', 'uses' => 'UddController@index']);
                        Route::get('/create', ['as' => 'create', 'uses' => 'UddController@create']);
                        Route::get('/update/{udd_id}', ['as' => 'update', 'uses' => 'UddController@update']);
                        Route::get('/delete-action/{udd_id}', ['as' => 'delete_action', 'uses' => 'UddController@delete_action']);

                        Route::post('/create-action', ['as' => 'create_action', 'uses' => 'UddController@create_action']);
                        Route::post('/update-action', ['as' => 'update_action', 'uses' => 'UddController@update_action']);
                    }
                );

                /**
                 * prefix admin.master.jenis_donor
                 * user
                 */
                Route::group(
                    [
                        'prefix'    => 'jenis_donor',
                        'as'        => 'jenis_donor.',
                    ],
                    function () {
                        Route::get('/', ['as' => 'index', 'uses' => 'JenisDonorController@index']);
                        Route::get('/getdata', ['as' => 'getdata', 'uses' => 'JenisDonorController@getData']);
                        Route::get('/create', ['as' => 'create', 'uses' => 'JenisDonorController@create']);
                        Route::get('/update/{jenis_donor_id}', ['as' => 'update', 'uses' => 'JenisDonorController@update']);
                        Route::get('/delete-action/{jenis_donor_id}', ['as' => 'delete_action', 'uses' => 'JenisDonorController@delete_action']);

                        Route::post('/create-action', ['as' => 'create_action', 'uses' => 'JenisDonorController@create_action']);
                        Route::post('/update-action', ['as' => 'update_action', 'uses' => 'JenisDonorController@update_action']);
                    }
                );

                /**
                 * prefix admin.master.news_category
                 * user
                 */
                Route::group(
                    [
                        'prefix'    => 'news_category',
                        'as'        => 'news_category.',
                    ],
                    function () {
                        Route::get('/', ['as' => 'index', 'uses' => 'NewsCategoryController@index']);
                        Route::get('/getdata', ['as' => 'getdata', 'uses' => 'NewsCategoryController@getData']);
                        Route::get('/create', ['as' => 'create', 'uses' => 'NewsCategoryController@create']);
                        Route::get('/update/{news_category_id}', ['as' => 'update', 'uses' => 'NewsCategoryController@update']);
                        Route::get('/delete-action/{news_category_id}', ['as' => 'delete_action', 'uses' => 'NewsCategoryController@delete_action']);

                        Route::post('/create-action', ['as' => 'create_action', 'uses' => 'NewsCategoryController@create_action']);
                        Route::post('/update-action', ['as' => 'update_action', 'uses' => 'NewsCategoryController@update_action']);
                    }
                );

                /**
                 * prefix admin.master.golongan_darah
                 * user
                 */
                Route::group(
                    [
                        'prefix'    => 'golongan_darah',
                        'as'        => 'golongan_darah.',
                    ],
                    function () {
                        Route::get('/', ['as' => 'index', 'uses' => 'GolonganDarahController@index']);
                        Route::get('/getdata', ['as' => 'getdata', 'uses' => 'GolonganDarahController@getData']);
                        // Route::get('/create', ['as' => 'create', 'uses' => 'GolonganDarahController@create']);
                        // Route::get('/update/{golongan_darah_id}', ['as' => 'update', 'uses' => 'GolonganDarahController@update']);
                        // Route::get('/delete-action/{golongan_darah_id}', ['as' => 'delete_action', 'uses' => 'GolonganDarahController@delete_action']);

                        // Route::post('/create-action', ['as' => 'create_action', 'uses' => 'GolonganDarahController@create_action']);
                        // Route::post('/update-action', ['as' => 'update_action', 'uses' => 'GolonganDarahController@update_action']);
                    }
                );

                /**
                 * prefix admin.master.produk_darah
                 * user
                 */
                Route::group(
                    [
                        'prefix'    => 'produk_darah',
                        'as'        => 'produk_darah.',
                    ],
                    function () {
                        Route::get('/', ['as' => 'index', 'uses' => 'ProdukDarahController@index']);
                        Route::get('/getdata', ['as' => 'getdata', 'uses' => 'ProdukDarahController@getData']);
                        // Route::get('/create', ['as' => 'create', 'uses' => 'ProdukDarahController@create']);
                        // Route::get('/update/{produk_darah_id}', ['as' => 'update', 'uses' => 'ProdukDarahController@update']);
                        // Route::get('/delete-action/{produk_darah_id}', ['as' => 'delete_action', 'uses' => 'ProdukDarahController@delete_action']);

                        // Route::post('/create-action', ['as' => 'create_action', 'uses' => 'ProdukDarahController@create_action']);
                        // Route::post('/update-action', ['as' => 'update_action', 'uses' => 'ProdukDarahController@update_action']);
                    }
                );

                /**
                 * prefix admin.master.user_driver
                 * user
                 */
                Route::group(
                    [
                        'prefix'    => 'user_driver',
                        'as'        => 'user_driver.',
                    ],
                    function () {
                        Route::get('/', ['as' => 'index', 'uses' => 'UserDriverController@index']);
                        Route::get('/getdata', ['as' => 'getdata', 'uses' => 'UserDriverController@getData']);
                        Route::get('/create', ['as' => 'create', 'uses' => 'UserDriverController@create']);
                        Route::get('/update/{user_driver_id}', ['as' => 'update', 'uses' => 'UserDriverController@update']);
                        Route::get('/delete-action/{user_driver_id}', ['as' => 'delete_action', 'uses' => 'UserDriverController@delete_action']);

                        Route::post('/create-action', ['as' => 'create_action', 'uses' => 'UserDriverController@create_action']);
                        Route::post('/update-action', ['as' => 'update_action', 'uses' => 'UserDriverController@update_action']);
                    }
                );

                /**
                 * prefix admin.master.rumah_sakit
                 * user
                 */
                Route::group(
                    [
                        'prefix'    => 'rumah_sakit',
                        'as'        => 'rumah_sakit.',
                    ],
                    function () {
                        Route::get('/', ['as' => 'index', 'uses' => 'RumahSakitController@index']);
                        Route::get('/getdata', ['as' => 'getdata', 'uses' => 'RumahSakitController@getData']);
                        Route::get('/create', ['as' => 'create', 'uses' => 'RumahSakitController@create']);
                        Route::get('/update/{rumah_sakit_id}', ['as' => 'update', 'uses' => 'RumahSakitController@update']);
                        Route::get('/delete-action/{rumah_sakit_id}', ['as' => 'delete_action', 'uses' => 'RumahSakitController@delete_action']);

                        Route::post('/create-action', ['as' => 'create_action', 'uses' => 'RumahSakitController@create_action']);
                        Route::post('/update-action', ['as' => 'update_action', 'uses' => 'RumahSakitController@update_action']);
                    }
                );
            }
        );
        /**end master */


        /**anamnesa */
        Route::group(
            [
                'prefix'    => 'anamnesa',
                'as'        => 'anamnesa.',
                'namespace' => 'Anamnesa'
            ],
            function () {
                /**
                * prefix admin.anamnesa.kategori_anamnesa
                * user
                */
                Route::group(
                    [
                        'prefix'    => 'kategori_anamnesa',
                        'as'        => 'kategori_anamnesa.',
                    ],
                    function () {
                        Route::get('/', ['as' => 'index', 'uses' => 'KategoriAnamnesaController@index']);
                        Route::get('/getdata', ['as' => 'getdata', 'uses' => 'KategoriAnamnesaController@getData']);
                        Route::get('/create', ['as' => 'create', 'uses' => 'KategoriAnamnesaController@create']);
                        Route::get('/update/{kategori_id}', ['as' => 'update', 'uses' => 'KategoriAnamnesaController@update']);
                        Route::get('/delete-action/{kategori_id}', ['as' => 'delete_action', 'uses' => 'KategoriAnamnesaController@delete_action']);

                        Route::post('/create-action', ['as' => 'create_action', 'uses' => 'KategoriAnamnesaController@create_action']);
                        Route::post('/update-action', ['as' => 'update_action', 'uses' => 'KategoriAnamnesaController@update_action']);
                    }
                );


                /**
                * prefix admin.anamnesa.tipe_anamnesa
                * user
                */
                Route::group(
                    [
                        'prefix'    => 'tipe_anamnesa',
                        'as'        => 'tipe_anamnesa.',
                    ],
                    function () {
                        Route::get('/', ['as' => 'index', 'uses' => 'TipeAnamnesaController@index']);
                        Route::get('/getdata', ['as' => 'getdata', 'uses' => 'TipeAnamnesaController@getData']);
                        Route::get('/create', ['as' => 'create', 'uses' => 'TipeAnamnesaController@create']);
                        Route::get('/update/{tipe_id}', ['as' => 'update', 'uses' => 'TipeAnamnesaController@update']);
                        Route::get('/delete-action/{tipe_id}', ['as' => 'delete_action', 'uses' => 'TipeAnamnesaController@delete_action']);

                        Route::post('/create-action', ['as' => 'create_action', 'uses' => 'TipeAnamnesaController@create_action']);
                        Route::post('/update-action', ['as' => 'update_action', 'uses' => 'TipeAnamnesaController@update_action']);
                    }
                );


                /**
                * prefix admin.anamnesa.pertanyaan_anamnesa
                * user
                */
                Route::group(
                    [
                        'prefix'    => 'pertanyaan_anamnesa',
                        'as'        => 'pertanyaan_anamnesa.',
                    ],
                    function () {
                        Route::get('/', ['as' => 'index', 'uses' => 'PertanyaanAnamnesaController@index']);
                        Route::get('/getdata', ['as' => 'getdata', 'uses' => 'PertanyaanAnamnesaController@getData']);
                        Route::get('/create', ['as' => 'create', 'uses' => 'PertanyaanAnamnesaController@create']);
                        Route::get('/update/{pertanyaan_id}', ['as' => 'update', 'uses' => 'PertanyaanAnamnesaController@update']);
                        Route::get('/delete-action/{pertanyaan_id}', ['as' => 'delete_action', 'uses' => 'PertanyaanAnamnesaController@delete_action']);

                        Route::post('/create-action', ['as' => 'create_action', 'uses' => 'PertanyaanAnamnesaController@create_action']);
                        Route::post('/update-action', ['as' => 'update_action', 'uses' => 'PertanyaanAnamnesaController@update_action']);
                    }
                );

                /**
                * prefix admin.anamnesa.persetujuan_anamnesa
                * user
                */
                Route::group(
                    [
                        'prefix'    => 'persetujuan_anamnesa',
                        'as'        => 'persetujuan_anamnesa.',
                    ],
                    function () {
                        Route::get('/', ['as' => 'index', 'uses' => 'PersetujuanAnamnesaController@index']);
                        Route::get('/getdata', ['as' => 'getdata', 'uses' => 'PersetujuanAnamnesaController@getData']);
                        Route::get('/create', ['as' => 'create', 'uses' => 'PersetujuanAnamnesaController@create']);
                        Route::get('/update/{persetujuan_id}', ['as' => 'update', 'uses' => 'PersetujuanAnamnesaController@update']);
                        Route::get('/delete-action/{persetujuan_id}', ['as' => 'delete_action', 'uses' => 'PersetujuanAnamnesaController@delete_action']);

                        Route::post('/create-action', ['as' => 'create_action', 'uses' => 'PersetujuanAnamnesaController@create_action']);
                        Route::post('/update-action', ['as' => 'update_action', 'uses' => 'PersetujuanAnamnesaController@update_action']);
                    }
                );
            }
        );

        /**data */
        Route::group(
            [
                'prefix'    => 'data',
                'as'        => 'data.',
                'namespace' => 'Data'
            ],
            function () {
                /**
                 * prefix admin.data.news
                 * user
                 */
                Route::group(
                    [
                        'prefix'    => 'news',
                        'as'        => 'news.',
                    ],
                    function () {
                        Route::get('/', ['as' => 'index', 'uses' => 'NewsController@index']);
                        Route::get('/getdata', ['as' => 'getdata', 'uses' => 'NewsController@getData']);
                        Route::get('/create', ['as' => 'create', 'uses' => 'NewsController@create']);
                        Route::get('/update/{news_id}', ['as' => 'update', 'uses' => 'NewsController@update']);
                        Route::get('/delete-action/{news_id}', ['as' => 'delete_action', 'uses' => 'NewsController@delete_action']);

                        Route::post('/create-action', ['as' => 'create_action', 'uses' => 'NewsController@create_action']);
                        Route::post('/update-action', ['as' => 'update_action', 'uses' => 'NewsController@update_action']);
                    }
                );


                /*
                 * prefix admin.data.kegiatan
                 * user
                 */
                Route::group(
                    [
                        'prefix'    => 'kegiatan',
                        'as'        => 'kegiatan.',
                    ],
                    function () {
                        Route::get('/', ['as' => 'index', 'uses' => 'KegiatanController@index']);
                        Route::get('/getdata', ['as' => 'getdata', 'uses' => 'KegiatanController@getData']);
                        Route::get('/create', ['as' => 'create', 'uses' => 'KegiatanController@create']);
                        Route::get('/update/{kegiatan_id}', ['as' => 'update', 'uses' => 'KegiatanController@update']);
                        Route::get('/delete-action/{kegiatan_id}', ['as' => 'delete_action', 'uses' => 'KegiatanController@delete_action']);

                        Route::post('/create-action', ['as' => 'create_action', 'uses' => 'KegiatanController@create_action']);
                        Route::post('/update-action', ['as' => 'update_action', 'uses' => 'KegiatanController@update_action']);
                    }
                );

                /*
                 * prefix admin.data.stock_darah
                 * user
                 */
                Route::group(
                    [
                        'prefix'    => 'stock_darah',
                        'as'        => 'stock_darah.',
                    ],
                    function () {
                        Route::get('/', ['as' => 'index', 'uses' => 'StockDarahController@index']);
                        Route::get('/getdata', ['as' => 'getdata', 'uses' => 'StockDarahController@getData']);
                        Route::get('/create', ['as' => 'create', 'uses' => 'StockDarahController@create']);
                        Route::get('/update/{stock_id}', ['as' => 'update', 'uses' => 'StockDarahController@update']);
                        Route::get('/delete-action/{stock_id}', ['as' => 'delete_action', 'uses' => 'StockDarahController@delete_action']);

                        Route::post('/create-action', ['as' => 'create_action', 'uses' => 'StockDarahController@create_action']);
                        Route::post('/update-action', ['as' => 'update_action', 'uses' => 'StockDarahController@update_action']);
                    }
                );

                /*
                 * prefix admin.data.data_galeri
                 * user
                 */
                Route::group(
                    [
                        'prefix'    => 'data_galeri',
                        'as'        => 'data_galeri.',
                    ],
                    function () {
                        Route::get('/', ['as' => 'index', 'uses' => 'DataGaleriController@index']);
                        Route::get('/getdata', ['as' => 'getdata', 'uses' => 'DataGaleriController@getData']);
                        Route::get('/create', ['as' => 'create', 'uses' => 'DataGaleriController@create']);
                        Route::get('/update/{galeri_id}', ['as' => 'update', 'uses' => 'DataGaleriController@update']);
                        Route::get('/delete-action/{galeri_id}', ['as' => 'delete_action', 'uses' => 'DataGaleriController@delete_action']);

                        Route::post('/create-action', ['as' => 'create_action', 'uses' => 'DataGaleriController@create_action']);
                        Route::post('/update-action', ['as' => 'update_action', 'uses' => 'DataGaleriController@update_action']);
                    }
                );
            }
        );    
        /**end data */

         /** notify */
         Route::group(
            [
                'prefix'    => 'notify',
                'as'        => 'notify.',
                'namespace' => 'Notify'
            ],
            function () {
                /**
                 * prefix admin.notify.udd
                 * user
                 */
                Route::get('/', ['as' => 'index', 'uses' => 'NotifyController@index']);
                Route::get('/getdata', ['as' => 'getdata', 'uses' => 'NotifyController@getData']);
                Route::get('/create', ['as' => 'create', 'uses' => 'NotifyController@create']);
                Route::get('/update/{notify_id}', ['as' => 'update', 'uses' => 'NotifyController@update']);
                Route::get('/delete-action/{notify_id}', ['as' => 'delete_action', 'uses' => 'NotifyController@delete_action']);

                Route::post('/create-action', ['as' => 'create_action', 'uses' => 'NotifyController@create_action']);
                Route::post('/update-action', ['as' => 'update_action', 'uses' => 'NotifyController@update_action']);
            }
        );
        /**end notify */

        /** jekdon */
        Route::group(
            [
                'prefix'    => 'jekdon',
                'as'        => 'jekdon.',
                'namespace' => 'JekDon'
            ],
            function () {
                /**
                 * prefix admin.jekdon.order
                 * user
                 */
                Route::group(
                    [
                        'prefix'    => 'order',
                        'as'        => 'order.',
                    ],
                    function () {
                        Route::get('/', ['as' => 'index', 'uses' => 'OrderController@index']);
                        Route::get('/getdata', ['as' => 'getdata', 'uses' => 'OrderController@getData']);
                        Route::get('/create', ['as' => 'create', 'uses' => 'OrderController@create']);
                        Route::get('/update/{order_id}', ['as' => 'update', 'uses' => 'OrderController@update']);
                        Route::get('/delete-action/{order_id}', ['as' => 'delete_action', 'uses' => 'OrderController@delete_action']);

                        Route::post('/create-action', ['as' => 'create_action', 'uses' => 'OrderController@create_action']);
                        Route::post('/update-action', ['as' => 'update_action', 'uses' => 'OrderController@update_action']);
                    }
                );

/**
                 * prefix admin.jekdon.hargakm
                 * user
                 */
                Route::group(
                    [
                        'prefix'    => 'hargakm',
                        'as'        => 'hargakm.',
                    ],
                    function () {
                        Route::get('/', ['as' => 'index', 'uses' => 'HargaPerKmController@index']);
                        Route::get('/getdata', ['as' => 'getdata', 'uses' => 'HargaPerKmController@getData']);
                        Route::get('/create', ['as' => 'create', 'uses' => 'HargaPerKmController@create']);
                        Route::get('/update/{hargakm_id}', ['as' => 'update', 'uses' => 'HargaPerKmController@update']);
                        Route::get('/delete-action/{hargakm_id}', ['as' => 'delete_action', 'uses' => 'HargaPerKmController@delete_action']);

                        Route::post('/create-action', ['as' => 'create_action', 'uses' => 'HargaPerKmController@create_action']);
                        Route::post('/update-action', ['as' => 'update_action', 'uses' => 'HargaPerKmController@update_action']);
                    }
                );
            }
        );
        /**end jekdon */

    }

);
