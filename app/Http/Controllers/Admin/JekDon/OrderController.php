<?php

namespace App\Http\Controllers\Admin\JekDon;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Helpers\Helper;
use Validator;
use Hashids;
use Auth;
use Yajra\Datatables\Datatables;

//load modelmu
use App\Model\JekDon\Order;
use App\Model\Master\RumahSakit;
use App\Model\Master\UserDriver;

class OrderController extends Controller
{
    /** 
    * Untuk CRUD Biar cepat
    * Silahkan ganti 
    * Order:: => dengan model anda
    * $id_order => ganti dengan id di model anda
    */
    
    /**
     * Title untuk judul di web
     * route digunakan untuk tempat resource (file path) + routing (route/web) diusahain sama ya biar gak ngubah"
     */
    private $title = 'App | JekDon - Order'; /**jangan lupa diganti*/
    private $route = 'admin.jekdon.order.'; //path awal foldernya ajah (misal folder di admin/dashboard) => 'admin.dashboard' | jangan lupa diganti

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
        $order  = Order::get();
        foreach ($order as $key => $value) {
            $value->driver      = $value->driver()->selectRaw('driver_id, driver_nama')->first();
            $value->rumah_sakit = $value->rumah_sakit()->selectRaw('rs_id, rs_address')->first();
        }
        
        $data = [
            //bawaan
            'title' => $this->title,
            'route' => $this->route,
            'data'  => $order
        ];
        // dd($order);
        return view($this->route . 'index', $data);
    }

    public function getData()
    {

        $query = Order::All();
        foreach ($query as $key => $value) {
            $value->no = $key + 1;
            $value->driver = $value->driver()->selectRaw('driver_id, driver_nama')->first();
            $value->rumah_sakit = $value->rumah_sakit()->selectRaw('rs_id, rs_name, rs_address')->first();
        }
        // dd($query);
        return Datatables::of($query)
            ->addColumn('aksi', function (Order $order) {
                return "
                        <a href='" . route($this->route . 'update', ['order_id' => Hashids::encode($order->order_id)]) . "' class='btn btn-sm btn-primary btn-edit'>Edit</a>
                        <a href='javascript:;' data-route='" . route($this->route . 'delete_action', ['order_id' => Hashids::encode($order->order_id)]) . "' class='btn btn-danger btn-sm btn-delete'>Delete</a>
                       ";
            })
            ->addColumn('order_status', function (Order $order) {
                if ($order->order_status == 'Null') {
                    return "<td>
                                <span class='badge badge-pill badge-default'>Belum Diterima</span>
                            </td>";
                } elseif($order->order_status == 'Persiapan') {
                    return "<td>
                                <span class='badge badge-pill badge-info'>Persiapan</span>
                            </td>";
                } elseif($order->order_status == 'Kirim') {
                    return "<td>
                                <span class='badge badge-pill badge-primary'>Kirim</span>
                            </td>";
                } elseif($order->order_status == 'Ganti Driver') {
                    return "<td>
                                <span class='badge badge-pill badge-default'>Ganti Driver</span>
                            </td>";
                } elseif($order->order_status == 'Sampai') {
                    return "<td>
                                <span class='badge badge-pill badge-success'>Sampai</span>
                            </td>";
                } else {
                    return "<td>
                                <span class='badge badge-pill badge-danger'>Batal</span>
                            </td>";
                }
            })
            ->rawColumns(['aksi','order_status'])
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
            'driver'    => UserDriver::get(),
            'rs'        => RumahSakit::get()
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
            'order_driver_id'   => 'required',
            'order_rs_id'       => 'required',
            'order_telepon'     => 'required|numeric',
            'order_description' => 'required', 
        ];
        /**digunakan untuk set message dari validatornya yang akan keluar gimna, :attribue itu udah langsung mendeteksi inputtan dari name="attribue" */
        $alert = [
            'required' => 'The :attribute is required',
            'numeric'  => 'Telepon Hanya Berisi Angka'
        ];
        $validator = Validator::make($request->all(), $rules, $alert);

        $today  = date("Y");
        $rand   = strtoupper(substr(uniqid(sha1(time())),0,4));
        $rand1   = strtoupper(substr(uniqid(sha1(time())),0,2));
        $order_code = $rand;
        $order_number = 'BO/' . date("m") . '/' . $today . '0000' . $rand1;

        if ($validator->passes()) {
            /**menggunakan transaction */
            DB::beginTransaction();
            $insert = $request->input();
            $insert['created_by']   = Auth::id();
            $insert['order_code']   = $order_code;
            $insert['order_number'] = $order_number;
            // dd($insert);
            
            $query = Order::create($insert);

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
    public function update($id_order)
    {

        if (session('success')) {
            alert()->html('', session('success'), 'success');
        }

        if (session('error')) {
            alert()->html('', session('error'), 'error');
        }


        $id_order = Hashids::decode($id_order);
        if (!empty($id_order)) {

            $cek_data = Order::where('order_id', $id_order[0])->first();
            $cek_data->driver = $cek_data->driver()->selectRaw('driver_id, driver_nama')->first();
            $cek_data->rumah_sakit = $cek_data->rumah_sakit()->selectRaw('rs_id, rs_name, rs_address')->first();

            if ($cek_data) {
                $data = [
                    //bawaan
                    'title'     => $this->title,
                    'route'     => $this->route,
                    'data'      => $cek_data,
                    'driver'    => UserDriver::get(),
                    'rs'        => RumahSakit::get()
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
            'order_driver_id'   => 'required',
            'order_rs_id'       => 'required',
            'order_telepon'     => 'required|numeric',
        ];
        $alert = [
            'required' => 'The :attribute is required',
            'numeric'  => 'Telepon Hanya Berisi Angka'
        ];
        $validator = Validator::make($request->all(), $rules, $alert);

        $id_order = Hashids::decode($request['order_id']);

        $today  = date("Y");
        $rand   = strtoupper(substr(uniqid(sha1(time())),0,4));
        $rand1   = strtoupper(substr(uniqid(sha1(time())),0,2));
        $order_code = $rand;
        $order_number = 'BO/' . date("m") . '/' . $today . '0000' . $rand1;

        if (!empty($id_order)) {
            /**cek apakah data_idnya ada ? */
            $cek_data = Order::where('order_id', $id_order[0])->first();

            if ($cek_data) {
                /**cek apakah id data benar" ada di DB ? */
                if ($validator->passes()) {
                    /**validatornya */

                    DB::beginTransaction();

                    $insert = $request->input();
                    $insert['created_by']   = Auth::id();
                    $insert['order_code']   = $order_code;
                    $insert['order_number'] = $order_number;
                    // dd($insert);

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
    public function delete_action($id_order)
    {
        $id_order = Hashids::decode($id_order);
        /**cek idnya apakah ada ? */

        if (!empty($id_order)) {

            $cek_data = Order::where('order_id', $id_order[0])->first();

            if ($cek_data) {
                DB::beginTransaction();
                $delete = $cek_data->delete();
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
            $message = 'Id not found or has been deleted';
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
