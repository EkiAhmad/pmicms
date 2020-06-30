<?php

namespace App\Http\Controllers\Admin\Data;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use Hashids;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;
use Auth;
use Yajra\Datatables\Datatables;

use App\Model\Data\DataNews;
use App\User;
use App\Model\Master\NewsCategory;

//load modelmu
class NewsController extends Controller
{
    /** 
    * Untuk CRUD Biar cepat
    * Silahkan ganti 
    * DataNews:: => dengan model anda
    * $news_id => ganti dengan id di model anda
    */
    
    /**
     * Title untuk judul di web
     * route digunakan untuk tempat resource (file path) + routing (route/web) diusahain sama ya biar gak ngubah"
     */
    private $title = 'App | Data - News'; /**jangan lupa diganti*/
    private $route = 'admin.data.news.'; //path awal foldernya ajah (misal folder di admin/dashboard) => 'admin.dashboard' | jangan lupa diganti

     public function __construct()
    {
        DB::enableQueryLog();
        /** nyalakan jika sudah set rolenya, jika ini dinyalakan halaman ini tidak akan keluar */
        /*$this->middleware('permission:Nama_Role_yang_dibuat-list|Nama_Role_yang_dibuat-create|Nama_Role_yang_dibuat-update|Nama_Role_yang_dibuat-delete', ['only' => ['index', 'create', 'update']]);
        $this->middleware('permission:Nama_Role_yang_dibuat-create', ['only' => ['create', 'create_action']]);
        $this->middleware('permission:Nama_Role_yang_dibuat-update', ['only' => ['update', 'update_action']]);
        $this->middleware('permission:Nama_Role_yang_dibuat-delete', ['only' => ['delete']]);*/
    }

    /**
     * Ini contoh crud yang sudah jalan
     * index digunakna untuk tampilan awal dari menu yang akan dibuat
     */
    public function index()
    {
        if (session('success')) {
            alert()->html('', session('success'), 'success');
        }

        if (session('error')) {
            alert()->html('', session('error'), 'error');
        }

        $data = [
            //bawaan
            'title' => $this->title,
            'route' => $this->route,
        ];
        // dd($data);
        return view($this->route . 'index', $data);
    }

    public function getData()
    {

        $query = DataNews::All();
        foreach ($query as $key => $value) {
            $value->no = $key + 1;
            $value->user = $value->user()->selectRaw('user_id, user_username')->first();
            $value->category = $value->category()->selectRaw('category_id, category_name')->first();
        }
        // dd($query);
        return Datatables::of($query)
            ->addColumn('aksi', function (DataNews $datanews) {
                return "
                        <a href='" . route($this->route . 'update', ['news_id' => Hashids::encode($datanews->news_id)]) . "' class='btn btn-sm btn-primary btn-edit'>Edit</a>
                        <a href='javascript:;' data-route='" . route($this->route . 'delete_action', ['news_id' => Hashids::encode($datanews->news_id)]) . "' class='btn btn-danger btn-sm btn-delete'>Delete</a>
                       ";
            })
            ->addColumn('type', function (DataNews $datanews) {
                if ($datanews->news_type == 'A') {
                    return "Berita";
                } else {
                    return "Edukasi";
                }
            })
            ->rawColumns(['aksi','type'])
            ->toJson();
    }

    /**
    * create digunakan untuk menampilkan tampilan buat
    */
    public function create()
    {
        $data = [
            //bawaan
            'title'     => $this->title,
            'route'     => $this->route,
            'author'    => User::get(),
            'category'  => NewsCategory::get(),
        ];

        if (session('success')) {
            alert()->html('', session('success'), 'success');
        }

        if (session('error')) {
            alert()->html('', session('error'), 'error');
        }

        return view($this->route . 'create', $data);
    }

    /**
     * create_action digunakan untuk aksi post
     * lengkap dengan validatornya
     */
    public function create_action(Request $request)
    {
        /**digunakan untuk set rule validator */
        $rules = [
            'news_title'        => 'required',
            'news_content'      => 'required',
            'news_image'        => 'required',
            'news_author_id'    => 'required',
            'news_type'         => 'required',
            'news_category_id'  => 'required',
        ];
        /**digunakan untuk set message dari validatornya yang akan keluar gimna, :attribue itu udah langsung mendeteksi inputtan dari name="attribue" */
        $alert = [
            'required' => 'The :attribute is required',
        ];
        $validator = Validator::make($request->all(), $rules, $alert);

        if ($validator->passes()) {
            /**menggunakan transaction */
            DB::beginTransaction();

            $insert = $request->input();
            $insert['created_by'] = Auth::id();

            $query = DataNews::create($insert);

            if ($query) {
                DB::commit();
                $message = 'Succefully';
                return redirect(route($this->route . 'index'))->with('success', Helper::parsing_alert($message));
            } else {
                DB::rollback();
                $message = 'Failed';
                return redirect()->back()->with('error', Helper::parsing_alert($message));
            }
        }
        /**kenapa menggunakan back ? karena baliknya pasti ke halaman sebelumnya */
        $message = Helper::parsing_alert($validator->errors()->all());
        return redirect()->back()->with('error', $message)->withInput();
    }

    /** update sama seperti create hanya saja digunakan untuk update (viewnya saja) */
    public function update($news_id)
    {

        if (session('success')) {
            alert()->html('', session('success'), 'success');
        }

        if (session('error')) {
            alert()->html('', session('error'), 'error');
        }


        $news_id = Hashids::decode($news_id);
        if (!empty($news_id)) {

            $cek_data = DataNews::where('news_id', $news_id[0])->first();
            $cek_data->user = $cek_data->user()->selectRaw('user_id, user_username')->first();
            $cek_data->category = $cek_data->category()->selectRaw('category_id, category_name')->first();

            if ($cek_data) {
                $data = [
                    //bawaan
                    'title'     => $this->title,
                    'route'     => $this->route,
                    'data'      => $cek_data,
                    'author'    => User::get(),
                    'category'  => NewsCategory::get(),
                ];
                return view($this->route . 'update', $data);
            }
            $message = 'Id not found or has been deleted';
            return redirect()->back()->with('error', $message);
        }
        $message = 'ID Not Found';
        return redirect()->back()->with('error', $message);
    }

    /**update_action POST 
     * Logikanya :
     * 1. Cek Hashids::decode dari data_id apalah benar" di hash ?
     * -iya
     *  2. Cek ID yang didapatkan dari hash apakah benar adanya ?
     *  -iya
     *    3. proses validate
     *    -iya
     *      4. Proses update
     *        - iya benar
     *        - tidak salah
     *    - tidak return error
     *  - tidak return id not found
     * -tidak skip reutrn id null
     */
    public function update_action(Request $request)
    {
        $rules = [
            'news_title'        => 'required',
            'news_content'      => 'required',
            'news_image'        => 'required',
            'news_author_id'    => 'required',
            'news_type'         => 'required',
            'news_category_id'  => 'required',
        ];
        $alert = [
            'required' => 'The :attribute is required',
        ];
        $validator = Validator::make($request->all(), $rules, $alert);

        $news_id = Hashids::decode($request['news_id']);

        if (!empty($news_id)) {
            /**cek apakah data_idnya ada ? */
            $cek_data = DataNews::where('news_id', $news_id[0])->first();

            if ($cek_data) {
                /**cek apakah id data benar" ada di DB ? */
                if ($validator->passes()) {
                    /**validatornya */

                    DB::beginTransaction();

                    $insert = $request->input();
                    $insert['updated_by'] = Auth::id();

                    $query = $cek_data->update($insert);

                    if ($query) {
                        DB::commit();
                        $message = 'Succefully';
                        return redirect(route($this->route . 'index'))->with('success', Helper::parsing_alert($message));
                    } else {
                        DB::rollback();
                        $message = 'Failed';
                        return redirect()->back()->with('error', Helper::parsing_alert($message));
                    }
                }

                $message = Helper::parsing_alert($validator->errors()->all());

                return redirect()->back()->with('error', $message);
            } else {
                $message = 'ID NOT FOUND';
                return redirect()->back()->with('error', $message);
            }
        } else {
            $message = 'ID NOT NULL';
            return redirect()->back()->with('error', $message);
        }
    }

    /**digunakan untuk delete 
     * Logikanya :
     * 1. Cek hash id
     * -ya
     *  2. Cek id dari hash
     *  - ya
     *      3. Proses delete
     *      -Ya
     *      -Tidak
     *  - tidak return id not found or has been deleted
     * -tidak reutrn id not found
     */
    public function delete_action($news_id)
    {
        $news_id = Hashids::decode($news_id);
        /**cek role idnya apakah ada ? */

        if (!empty($news_id)) {

            $cek_role = DataNews::where('news_id', $news_id[0])->first();

            if ($cek_role) {
                DB::beginTransaction();
                $delete = $cek_role->delete();
                if ($delete) {
                    DB::commit();
                    $message = 'Succesfully';
                    $response = [
                        'message' => $message,
                        'status'   => true,
                    ];
                    return response()->json($response);
                    // return redirect()->back()->with('success', $message);
                } else {
                    DB::rollback();
                    $message = 'Failed';
                    $response = [
                        'message' => $message,
                        'status'   => false,
                    ];
                    return response()->json($response);
                    // return redirect()->back()->with('error', $message);
                }
            }
            $message = 'Id role not found or has been deleted';
            $response = [
                'message' => $message,
                'status'   => false,
            ];
            return response()->json($response);
            // return redirect()->back()->with('error', $message);
        }
        $message = 'ID Not Found';
        $response = [
            'message' => $message,
            'status'   => false,
        ];
        return response()->json($response);
        // return redirect()->back()->with('error', $message);
    }
}
