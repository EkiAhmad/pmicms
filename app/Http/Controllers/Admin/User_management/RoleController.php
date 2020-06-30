<?php

namespace App\Http\Controllers\Admin\User_management;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;
use Hashids;

/**model */

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Model\RoleHasPermission;

class RoleController extends Controller
{

    /**
     * Title untuk judul di web
     * route digunakan untuk tempat resource (file path) + routing (route/web) diusahain sama ya biar gak ngubah"
     */
    private $title = 'Admin | User Magement - Role';
    private $route = 'admin.user_management.role.'; //path awal foldernya ajah (misal folder di admin/dashboard) => 'admin.dashboard'
    public function __construct()
    {
        DB::getQueryLog();
        $this->middleware('permission:role-list|role-create|role-update|role-delete', ['only' => ['index', 'create', 'update']]);
        $this->middleware('permission:role-create', ['only' => ['create', 'create_action']]);
        $this->middleware('permission:role-update', ['only' => ['update', 'update_action']]);
        $this->middleware('permission:role-delete', ['only' => ['delete']]);
    }

    /**
     * Ini contoh crud yang sudah jalan
     * index digunakna untuk tampilan awal dari menu yang akan dibuat
     * session" itu ambil dari sweetalert langsung jadi udah langsung digunakan
     * untuk yang index susuannya begitu, kalau mau menambahkan silahkan
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
            'data'  => Role::get(),
        ];
        return view($this->route . 'index', $data);
    }

    /**
     * create digunakan untuk menampilkan tampilan buat
     */
    public function create()
    {
        /**set permission dengan cara dibagi 4 - 4 */
        $permission = Permission::get();
        $jumlah_permission = $permission->count();
        $limit = 4;
        $take = 0;
        $jumlah_looping = ceil($jumlah_permission / $limit);
        $arr_permission = [];
        for ($i = 0; $i < $jumlah_looping; $i++) {
            // $cek_limit[] = $limit;
            // $cek_take[] = $take;
            $limit_data = 4;
            $permission = Permission::take($limit_data)->skip($take)->get();
            $cek_permission[] = $permission;
            $arr_permission[$i] = $permission;
            $take = $limit;
            $limit += 4;
        }
        // dd($arr_permission);
        /**end set permission */
        $data = [
            //bawaan
            'title' => $this->title,
            'route' => $this->route,
            'data'  => $arr_permission,
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

        $cek_permission_id = !empty($request['permission_id']);
        // dd($cek_permission_id);

        if ($cek_permission_id) {
            $rules = [
                'name' => 'required|min:2|unique:roles,name',
            ];
            /**digunakan untuk set message dari validatornya yang akan keluar gimna, :attribue itu udah langsung mendeteksi inputtan dari name="attribue" */
            $alert = [
                'required'  => 'The :attribute is required',
                'min'       => ':attribute Min 2 Char'
            ];
            $validator = Validator::make($request->all(), $rules, $alert);

            if ($validator->passes()) {
                /**menggunakan transaction */
                DB::beginTransaction();
                $insert_role = Role::create($request->only('name'));
                $data_has_role = [];
                foreach ($request['permission_id'] as $key => $value) {
                    $data_has_role[] = [
                        'permission_id' => $value,
                        'role_id'       => $insert_role->id
                    ];
                }
                $insert_has_role = RoleHasPermission::insert($data_has_role);

                if ($insert_role && $insert_has_role) {
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
        $message = 'Please filled the permission least one';
        return redirect()->back()->with('error', $message)->withInput();
    }

    /** update sama seperti create hanya saja digunakan untuk update (viewnya saja) */
    public function update($role_id)
    {

        if (session('success')) {
            alert()->html('', session('success'), 'success');
        }

        if (session('error')) {
            alert()->html('', session('error'), 'error');
        }


        $role_id = Hashids::decode($role_id);
        if (!empty($role_id)) {

            $cek_role = Role::where('id', $role_id[0])->first();
            /**set permission dengan cara dibagi 4 - 4 */
            $permission = Permission::get();
            $jumlah_permission = $permission->count();
            $limit = 4;
            $take = 0;
            $jumlah_looping = ceil($jumlah_permission / $limit);
            $arr_permission = [];
            for ($i = 0; $i < $jumlah_looping; $i++) {
                // $cek_limit[] = $limit;
                // $cek_take[] = $take;
                $limit_data = 4;
                $permission = Permission::take($limit_data)->skip($take)->get();
                $cek_permission[] = $permission;
                $arr_permission[$i] = $permission;
                $take = $limit;
                $limit += 4;
            }
            /**end set permission */
            /**menambahkan object permission di dalam role, digunakan untuk cek diviewnya nanti permissionnya mana aja yang dipilih */
            $cek_role->permission = RoleHasPermission::where('role_id', $cek_role->id)
                ->get()
                ->pluck('permission_id')
                ->toArray();

            if ($cek_role) {
                $data = [
                    //bawaan
                    'title' => $this->title,
                    'route' => $this->route,
                    'data'  => $cek_role,
                    'permission' => $arr_permission,
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
     * LOGIKANYA :
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
            'name' => 'required|min:2',
        ];
        $alert = [
            'required'  => 'The :attribute is required',
            'min'       => ':attribute Min 2 Char'
        ];
        $validator = Validator::make($request->all(), $rules, $alert);

        $role_id = Hashids::decode($request['id']);

        $cek_permission_id = !empty($request['permission_id']);

        if ($cek_permission_id) {
            if (!empty($role_id)) {
                /**cek apakah role_idnya ada ? */
                $cek_role = Role::where('id', $role_id[0])->first();

                if ($cek_role) {
                    /**cek apakah id rolenya benar" ada di DB ? */
                    if ($validator->passes()) {
                        /**validatornya */

                        DB::beginTransaction();
                        $update_role = $cek_role->update($request->only('name'));

                        /**delete has role dlu */
                        RoleHasPermission::where('role_id', $cek_role->id)->delete();
                        /**proses input has role */
                        $data_has_role = [];
                        foreach ($request['permission_id'] as $key => $value) {
                            $data_has_role[] = [
                                'permission_id' => $value,
                                'role_id'       => $cek_role->id
                            ];
                        }
                        $insert_has_role = RoleHasPermission::insert($data_has_role);

                        if ($update_role && $insert_has_role) {
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
        $message = 'Permission must be filled least one';
        return redirect()->back()->with('error', $message);
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
    public function delete_action($role_id)
    {
        $role_id = Hashids::decode($role_id);
        /**cek role idnya apakah ada ? */

        if (!empty($role_id)) {

            $cek_role = Role::where('id', $role_id[0])->first();

            if ($cek_role) {
                DB::beginTransaction();
                $delete = $cek_role->delete();
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
