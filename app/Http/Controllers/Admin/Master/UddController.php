<?php

namespace App\Http\Controllers\Admin\Master;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use Hashids;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;

//load modelmu
use App\Model\Master\MasterUdd;

class UddController extends Controller
{
    /** 
     * Untuk CRUD Biar cepat
     * Silahkan ganti 
     * MasterUdd:: => dengan model anda
     * $udd_id => ganti dengan id di model anda
     */

    /**
     * Title untuk judul di web
     * route digunakan untuk tempat resource (file path) + routing (route/web) diusahain sama ya biar gak ngubah"
     */
    private $title = 'App | Master Data - UDD';
    /**jangan lupa diganti*/
    private $route = 'admin.master.udd.'; //path awal foldernya ajah (misal folder di admin/dashboard) => 'admin.dashboard' | jangan lupa diganti

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
            'data'  => MasterUdd::get(),
        ];
        // dd($data);
        return view($this->route . 'index', $data);
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
            'name'      => 'required|min:4|unique:master_udd,name',
            'kode_udd'  => 'required|between:4,4|unique:master_udd,kode_udd',
        ];
        /**digunakan untuk set message dari validatornya yang akan keluar gimna, :attribue itu udah langsung mendeteksi inputtan dari name="attribue" */
        $alert = [
            'required'  => 'The :attribute is required',
            'unique'    => ':attribute is exists',
            'min'       => ':attribute minimal :min character',
            'between'   => ':attribute min and max value is :min',
        ];
        $validator = Validator::make($request->all(), $rules, $alert);

        if ($validator->passes()) {
            /**menggunakan transaction */
            DB::beginTransaction();
            $query = MasterUdd::create($request->input());

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
    public function update($udd_id)
    {

        if (session('success')) {
            alert()->html('', session('success'), 'success');
        }

        if (session('error')) {
            alert()->html('', session('error'), 'error');
        }


        $udd_id = Hashids::decode($udd_id);
        if (!empty($udd_id)) {

            $cek_data = MasterUdd::where('id', $udd_id[0])->first();

            if ($cek_data) {
                $data = [
                    //bawaan
                    'title' => $this->title,
                    'route' => $this->route,
                    'data'  => $cek_data
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
            'name'      => 'required|min:4',
            'kode_udd'  => 'required|between:4,4',
        ];
        /**digunakan untuk set message dari validatornya yang akan keluar gimna, :attribue itu udah langsung mendeteksi inputtan dari name="attribue" */
        $alert = [
            'required'  => 'The :attribute is required',
            'min'       => ':attribute minimal :min character',
            'between'   => ':attribute min and max value is :min',
        ];
        $validator = Validator::make($request->all(), $rules, $alert);

        $udd_id = Hashids::decode($request['id']);

        if (!empty($udd_id)) {
            /**cek apakah datanya ada ? */
            $cek_data = MasterUdd::where('id', $udd_id[0])->first();

            if ($cek_data) {
                /**cek apakah id rolenya benar" ada di DB ? */
                if ($validator->passes()) {
                    /**validatornya */

                    DB::beginTransaction();
                    $query = $cek_data->update($request->input());

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
    public function delete_action($udd_id)
    {
        $udd_id = Hashids::decode($udd_id);
        /**cek role idnya apakah ada ? */

        if (!empty($udd_id)) {

            $cek_data = MasterUdd::where('id', $udd_id[0])->first();

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
