<?php

namespace App\Http\Controllers\Admin\User_management;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Helpers\Helper;
use Validator;
use Hashids;
use Spatie\Permission\Models\Permission;
use Yajra\Datatables\Datatables;
//load modelmu

class PermissionController extends Controller
{
    /** 
     * Untuk CRUD Biar cepat
     * Silahkan ganti 
     * Permission:: => dengan model anda
     * $permission_id => ganti dengan id di model anda
     */

    /**
     * Title untuk judul di web
     * route digunakan untuk tempat resource (file path) + routing (route/web) diusahain sama ya biar gak ngubah"
     */
    private $title = 'App | Permission';
    /**jangan lupa diganti*/
    private $route = 'admin.user_management.permission.'; //path awal foldernya ajah (misal folder di admin/dashboard) => 'admin.dashboard' | jangan lupa diganti
    private $roles = ['list', 'create', 'update', 'delete'];
    public function __construct()
    {
        DB::getQueryLog();
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

        $query = Permission::All();
        foreach ($query as $key => $value) {
            $value->no = $key + 1;
        }
        // dd($query);
        return Datatables::of($query)
            ->addColumn('aksi', function (Permission $permission) {
                return "
                        <a href='" . route($this->route . 'update', ['permission_id' => Hashids::encode($permission->id)]) . "' class='btn btn-sm btn-primary btn-edit'>Edit</a>
                        <a href='javascript:;' data-route='" . route($this->route . 'delete_action', ['permission_id' => Hashids::encode($permission->id)]) . "' class='btn btn-danger btn-sm btn-delete'>Delete</a>
                       ";
            })
            ->rawColumns(['aksi'])
            ->toJson();
    }
    /**
     * create digunakan untuk menampilkan tampilan buat
     */
    public function create()
    {
        $data = [
            //bawaan
            'title' => $this->title,
            'route' => $this->route,
            'roles' => $this->roles
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
            'name'  => 'required|min:2|unique:roles,name',
            'roles' => 'required',
        ];
        /**digunakan untuk set message dari validatornya yang akan keluar gimna, :attribue itu udah langsung mendeteksi inputtan dari name="attribue" */
        $alert = [
            'required'  => 'The :attribute is required',
            'min'       => ':attribute Min :min Char'
        ];
        $validator = Validator::make($request->all(), $rules, $alert);

        if ($validator->passes()) {
            /**menggunakan transaction */

            $insert = [];

            foreach ($request['roles'] as $key => $value) {
                $insert[] = [
                    'name' => $request['name'] . '-' . $value,
                    'guard_name' => 'web',
                ];
            }

            DB::beginTransaction();
            $query = Permission::insert($insert);

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
    public function update($permission_id)
    {

        if (session('success')) {
            alert()->html('', session('success'), 'success');
        }

        if (session('error')) {
            alert()->html('', session('error'), 'error');
        }


        $permission_id = Hashids::decode($permission_id);
        if (!empty($permission_id)) {

            $cek_role = Permission::where('id', $permission_id[0])->first();

            if ($cek_role) {
                $data = [
                    //bawaan
                    'title' => $this->title,
                    'route' => $this->route,
                    'data'  => $cek_role
                ];
                return view($this->route . 'update', $data);
            }
            $message = 'Id role not found or has been deleted';
            return redirect()->back()->with('error', $message);
        }
        $message = 'ID Not Found';
        return redirect()->back()->with('error', $message);
    }

    /**update_action POST 
     * Logikanya :
     * 1. Cek Hashids::decode dari role_id apalah benar" di hash ?
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
            'name' => 'required|min:2|unique:roles,name',
        ];
        $alert = [
            'required'  => 'The :attribute is required',
            'min'       => ':attribute Min 2 Char'
        ];
        $validator = Validator::make($request->all(), $rules, $alert);

        $permission_id = Hashids::decode($request['id']);

        if (!empty($permission_id)) {
            /**cek apakah role_idnya ada ? */
            $cek_role = Permission::where('id', $permission_id[0])->first();

            if ($cek_role) {
                /**cek apakah id rolenya benar" ada di DB ? */
                if ($validator->passes()) {
                    /**validatornya */

                    DB::beginTransaction();
                    $query = $cek_role->update($request->input());

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
    public function delete_action($permission_id)
    {
        $permission_id = Hashids::decode($permission_id);
        /**cek role idnya apakah ada ? */

        if (!empty($permission_id)) {

            $cek_role = Permission::where('id', $permission_id[0])->first();

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
