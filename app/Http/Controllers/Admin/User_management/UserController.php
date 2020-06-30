<?php

namespace App\Http\Controllers\Admin\User_management;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;

use Hashids;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;

//load modelmu
use App\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use App\Model\Master\MasterUdd;
use App\Model\ModelHasRoles;

class UserController extends Controller
{
    /** 
     * Untuk CRUD Biar cepat
     * Silahkan ganti 
     * User:: => dengan model anda
     * $user_id => ganti dengan id di model anda
     */

    /**
     * Title untuk judul di web
     * route digunakan untuk tempat resource (file path) + routing (route/web) diusahain sama ya biar gak ngubah"
     */
    private $title = 'App | User Management - User';
    /**jangan lupa diganti*/
    private $route = 'admin.user_management.user.'; //path awal foldernya ajah (misal folder di admin/dashboard) => 'admin.dashboard' | jangan lupa diganti

    public function __construct()
    {
        DB::enableQueryLog();
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
            'data'  => User::get(),
        ];
        // dd($data);
        return view($this->route . 'index', $data);
    }

    /**
     * create digunakan untuk menampilkan tampilan buat
     */
    public function create()
    {
        /**set role dengan cara dibagi 4 - 4 */
        $role = Role::get();
        $jumlah_role = $role->count();
        $limit = 4;
        $take = 0;
        $jumlah_looping = ceil($jumlah_role / $limit);
        $arr_role = [];
        for ($i = 0; $i < $jumlah_looping; $i++) {
            // $cek_limit[] = $limit;
            // $cek_take[] = $take;
            $limit_data = 4;
            $role = Role::take($limit_data)->skip($take)->get();
            $cek_data[] = $role;
            $arr_role[$i] = $role;
            $take = $limit;
            $limit += 4;
        }
        /**master udd */
        $data_udd = MasterUdd::get();
        /**end master udd */
        $data = [
            //bawaan
            'title' => $this->title,
            'route' => $this->route,
            'role'  => $arr_role,
            'udd'   => $data_udd,
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
            'user_username' => 'required|min:4|unique:users,user_username',
            'password'      => 'required|min:6',
            'role_id'       => 'required',
            'udd_id'        => 'required',
        ];
        /**digunakan untuk set message dari validatornya yang akan keluar gimna, :attribue itu udah langsung mendeteksi inputtan dari name="attribue" */
        $alert = [
            'unique'    => ':attribute already exists',
            'required'  => 'The :attribute is required',
            'min'       => ':attribute Min :min  Char'
        ];

        $validator = Validator::make($request->all(), $rules, $alert);

        if ($validator->passes()) {
            /**menggunakan transaction */
            DB::beginTransaction();
            $insert = [
                'user_username' => $request['user_username'],
                'password'      => Hash::make($request['password']),
                'udd_id'        => $request['udd_id'],
            ];
            $query = User::create($insert);
            $query->assignRole($request['role_id']);

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
    public function update($user_id)
    {

        if (session('success')) {
            alert()->html('', session('success'), 'success');
        }

        if (session('error')) {
            alert()->html('', session('error'), 'error');
        }


        $user_id = Hashids::decode($user_id);
        $data_udd = MasterUdd::get();
        if (!empty($user_id)) {
            $role = Role::get();
            $jumlah_role = $role->count();
            $limit = 4;
            $take = 0;
            $jumlah_looping = ceil($jumlah_role / $limit);
            $arr_role = [];
            for ($i = 0; $i < $jumlah_looping; $i++) {
                // $cek_limit[] = $limit;
                // $cek_take[] = $take;
                $limit_data = 4;
                $role = Role::take($limit_data)->skip($take)->get();
                $cek_data[] = $role;
                $arr_role[$i] = $role;
                $take = $limit;
                $limit += 4;
            }

            $cek_data = User::where('user_id', $user_id[0])->first();
            $cek_data->role = $cek_data->roles->pluck('id')->toArray();
            $cek_data->udd  = $cek_data->udd->first()->id ?? null;

            if ($cek_data) {
                $data = [
                    //bawaan
                    'title' => $this->title,
                    'route' => $this->route,
                    'data'  => $cek_data,
                    'role'  => $arr_role,
                    'udd'   => $data_udd,
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
        /**digunakan untuk set rule validator */
        $rules = [
            'user_username' => 'required|min:4',
            'role_id'       => 'required',
            'udd_id'        => 'required',
        ];
        /**digunakan untuk set message dari validatornya yang akan keluar gimna, :attribue itu udah langsung mendeteksi inputtan dari name="attribue" */
        $alert = [
            'required'  => 'The :attribute is required',
            'min'       => ':attribute Min :min  Char'
        ];
        $validator = Validator::make($request->all(), $rules, $alert);

        $user_id = Hashids::decode($request['user_id']);

        if (!empty($user_id)) {
            /**cek apakah id ada ? */
            $cek_data = User::where('user_id', $user_id[0])->first();

            /**cek user_username apakah ada diDB dan bukan punya si ID ini ? */
            $cek_username = User::where('user_username', $request['user_username'])
                ->where('user_id', '!=', $user_id)
                ->first();
            if (!empty($cek_username)) {
                $message = 'Username is already exists';
                return redirect()->back()->with('error', $message);
            }

            if ($cek_data) {
                /**cek apakah id rolenya benar" ada di DB ? */
                if ($validator->passes()) {
                    /**validatornya */
                    $update = [
                        'user_username' => $request['user_username'],
                        'udd_id'        => $request['udd_id'],
                    ];

                    /**jika passwordnya disii */
                    if ($request['password']) {
                        $update['password'] = Hash::make($request['password']);
                    }

                    DB::beginTransaction();
                    ModelHasRoles::where('model_id', $user_id)->delete();
                    $query = $cek_data->update($update);
                    $cek_data->assignRole($request['role_id']);

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
    public function delete_action($user_id)
    {
        $user_id = Hashids::decode($user_id);
        /**cek role idnya apakah ada ? */

        if (!empty($user_id)) {

            $cek_data = User::where('user_id', $user_id[0])->first();

            if ($cek_data) {
                DB::beginTransaction();
                $delete = $cek_data->delete();
                if ($delete) {
                    DB::commit();
                    $message = 'Succesfully';
                    return redirect()->back()->with('success', $message);
                } else {
                    DB::rollback();
                    $message = 'Failed';
                    return redirect()->back()->with('error', $message);
                }
            }
            $message = 'Id role not found or has been deleted';
            return redirect()->back()->with('error', $message);
        }
        $message = 'ID Not Found';
        return redirect()->back()->with('error', $message);
    }
}
