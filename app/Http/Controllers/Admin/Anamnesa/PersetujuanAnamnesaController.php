<?php

namespace App\Http\Controllers\Admin\Anamnesa;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Helpers\Helper;
use Validator;
use Hashids;

//load modelmu
use App\Model\Anamnesa\PersetujuanAnamnesa;
use Auth;
use Yajra\Datatables\Datatables;
class PersetujuanAnamnesaController extends Controller
{
    /** 
    * Untuk CRUD Biar cepat
    * Silahkan ganti 
    * PersetujuanAnamnesa:: => dengan model anda
    * $id_persetujuan_anamnesa => ganti dengan id di model anda
    */
    
    /**
     * Title untuk judul di web
     * route digunakan untuk tempat resource (file path) + routing (route/web) diusahain sama ya biar gak ngubah"
     */
    private $title = 'App Admin - Persetujuan Anamnesa'; /**jangan lupa diganti*/
    private $route = 'admin.anamnesa.persetujuan_anamnesa.'; //path awal foldernya ajah (misal folder di admin/dashboard) => 'admin.dashboard' | jangan lupa diganti

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
            // 'data'  => PersetujuanAnamnesa::get(),
        ];
        // dd($data);
        return view($this->route . 'index', $data);
    }

    public function getData()
    {

        $query = PersetujuanAnamnesa::All();
        foreach ($query as $key => $value) {
            $value->no = $key + 1;
        }
        // dd($query);
        return Datatables::of($query)
            ->addColumn('aksi', function (PersetujuanAnamnesa $persetujuan) {
                return "
                        <a href='" . route($this->route . 'update', ['persetujuan_id' => Hashids::encode($persetujuan->persetujuan_id)]) . "' class='btn btn-sm btn-primary btn-edit'>Edit</a>
                        <a href='javascript:;' data-route='" . route($this->route . 'delete_action', ['persetujuan_id' => Hashids::encode($persetujuan->persetujuan_id)]) . "' class='btn btn-danger btn-sm btn-delete'>Delete</a>
                       ";
            })
            ->rawColumns(['aksi', 'persetujuan_content'])
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
            'route' => $this->route,
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
            'persetujuan_content' => 'required'
        ];
        /**digunakan untuk set message dari validatornya yang akan keluar gimna, :attribue itu udah langsung mendeteksi inputtan dari name="attribue" */
        $alert = [
            'required' => ':attribute is required'
        ];
        $validator = Validator::make($request->all(), $rules, $alert);

        if ($validator->passes()) {
            /**menggunakan transaction */
            DB::beginTransaction();
            $insert = $request->input();
            $insert['persetujuan_tipe']       = '1';
            $insert['persetujuan_created_by'] = Auth::id();
            $insert['persetujuan_updated_by'] = Auth::id();
            $insert['persetujuan_created_at'] = NOW();
            $insert['persetujuan_updated_at'] = NOW();
            $query = PersetujuanAnamnesa::create($insert);

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
    public function update($id_persetujuan_anamnesa)
    {

        if (session('success')) {
            alert()->html('', session('success'), 'success');
        }

        if (session('error')) {
            alert()->html('', session('error'), 'error');
        }


        $id_persetujuan_anamnesa = Hashids::decode($id_persetujuan_anamnesa);
        if (!empty($id_persetujuan_anamnesa)) {

            $cek_data = PersetujuanAnamnesa::where('persetujuan_id', $id_persetujuan_anamnesa[0])->first();

            if ($cek_data) {
                $data = [
                    //bawaan
                    'title' => $this->title,
                    'route' => $this->route,
                    'data'  => $cek_data
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
            'persetujuan_content' => 'required'
        ];
        $alert = [
            'required' => ':attribute is required'
        ];
        $validator = Validator::make($request->all(), $rules, $alert);

        $id_persetujuan_anamnesa = Hashids::decode($request['persetujuan_id']);

        if (!empty($id_persetujuan_anamnesa)) {
            /**cek apakah data_idnya ada ? */
            $cek_data = PersetujuanAnamnesa::where('persetujuan_id', $id_persetujuan_anamnesa[0])->first();

            if ($cek_data) {
                /**cek apakah id data benar" ada di DB ? */
                if ($validator->passes()) {
                    /**validatornya */

                    DB::beginTransaction();
                    $insert = $request->input();
                    $insert['persetujuan_updated_by'] = Auth::id();
                    $insert['persetujuan_updated_at'] = NOW();
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
    public function delete_action($id_persetujuan_anamnesa)
    {
        $id_persetujuan_anamnesa = Hashids::decode($id_persetujuan_anamnesa);
        /**cek idnya apakah ada ? */

        if (!empty($id_persetujuan_anamnesa)) {

            $cek_data = PersetujuanAnamnesa::where('persetujuan_id', $id_persetujuan_anamnesa[0])->first();

            if ($cek_data) {
                DB::beginTransaction();
                $delete = $cek_data->delete();
                if ($delete) {
                    DB::commit();
                    $message = 'Succesfully';
                    // return redirect()->back()->with('success', $message);
                    $response = [
                        'message' => $message,
                        'status'  => true,
                    ];
                    return response()->json($response);
                } else {
                    DB::rollback();
                    $message = 'Failed';
                    // return redirect()->back()->with('error', $message);
                    $response = [
                        'message' => $message,
                        'status'  => false,
                    ];
                    return response()->json($response);
                }
            }
            $message = 'Id not found or has been deleted';
            // return redirect()->back()->with('error', $message);
            $response = [
                        'message' => $message,
                        'status'  => false,
                    ];
            return response()->json($response);
        }
        $message = 'ID Not Found';
        // return redirect()->back()->with('error', $message);
        $response = [
                        'message' => $message,
                        'status'  => false,
                    ];
        return response()->json($response);
    }
}
