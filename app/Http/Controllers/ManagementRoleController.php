<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

use Carbon\Carbon;
use App\Rules\ReCaptcha;
use App\Http\Controllers\Helpers\mainController;

// Database
use Illuminate\Support\Facades\DB;
use App\Models\mRoles;
use App\Models\mMenu;
use App\Models\mAuthorization;
use App\Models\vMenuAuthorization;

class ManagementRoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function page_indexManagementRole(Request $request){
        $model['route'] = 'Management Role';
        $model['msrole'] = mRoles::get();
        return view('pages.management-role.v_index', ['model' => $model]);
    }
    
    public function act_tambahManagementRole(Request $request)
    {
        $status = false;
        $response_code = 'RC400';
        $message = 'Data Gagal Terjadi Gangguan..';
        $dataAPI = null;

        // wajib menggunakan request ajax
        if ($request->ajax()) {
            // dd($request->all());
            $validator = Validator::make($request->all(), [
                'form_role_nama' => 'required',
                'recaptcha' => ['required', new ReCaptcha]
            ]);

            // Ketika data kiriman tidak sesuai
            if ($validator->fails())
            {
                $response_code = "RC400";
                $message = "Form Tidak Tervalidasi Dengan Sistem..!!";
                return $this->onResult($status, $response_code, $message, $dataAPI);
            }

            $form_role_nama = strtoupper($request->form_role_nama);
            // Cek Data Menu Dalam Database
            $checkExistingDataRole =  mRoles::where('name', $form_role_nama)->first();
            
            if($checkExistingDataRole)
            {
                $response_code = "RC401";
                $message = "Data Role User Sudah Ada Dalam Sistem";
                return $this->onResult($status, $response_code, $message, $dataAPI);
            }

            $form_role_deskripsi = $form_role_nama;
            if($request->form_role_deskripsi != null)
            {
                $form_role_deskripsi = $request->form_role_deskripsi;
            }

            DB::beginTransaction();
            try {
                // menyimpan data transaksi kedalam database
                $AddDBTransaksi = new mRoles();

                $AddDBTransaksi->uuid = (string) Str::uuid();
                $AddDBTransaksi->name = $form_role_nama;
                $AddDBTransaksi->description = $form_role_deskripsi;
                $AddDBTransaksi->status = 1;
                $AddDBTransaksi->created_at = Carbon::now('Asia/Jakarta');

                $AddDBTransaksi->save();

                DB::commit();

                $status = true;
                $response_code = 'RC200';
                $message = 'Data role berhasil ditambahkan, terimakasih !';
                $dataAPI = null;

                return $this->onResult($status, $response_code, $message, $dataAPI);

            } catch (\Throwable $error) {
                DB::rollback();
                Log::critical($error);
                
                $response_code = "RC400";
                $message = "Sistem gagal proses data, Kesalahan saat simpan data !!";
                return $this->onResult($status, $response_code, $message, $dataAPI);
            }
        }else {
            $response_code = "RC400";
            $message = "Apakah Anda Robot Ingin Masuk Kedalam Sistem..!!";
            return $this->onResult($status, $response_code, $message, $dataAPI);
        }
    }

    public function get_detailManagementRole(Request $request)
    {
        $status = false;
        $response_code = 'RC400';
        $message = 'Data Gagal Terjadi Gangguan..';
        $dataAPI = null;

        // wajib menggunakan request ajax
        if ($request->ajax()) {
            // dd($request->all());
            $validator = Validator::make($request->all(), [
                'data_id' => 'required',
            ]);

            // Ketika data kiriman tidak sesuai
            if ($validator->fails())
            {
                $response_code = "RC400";
                $message = "Form Tidak Tervalidasi Dengan Sistem..!!";
                return $this->onResult($status, $response_code, $message, $dataAPI);
            }

            // Cek Data Menu Dalam Database
            $checkExistingDataRole =  mRoles::where('uuid', $request->data_id)->first();
            
            if(!$checkExistingDataRole)
            {
                $response_code = "RC401";
                $message = "Data Role User Tidak Ada Dalam Sistem";
                return $this->onResult($status, $response_code, $message, $dataAPI);
            }

            $dataAPI = Str::random(3).Crypt::encryptString(json_encode($checkExistingDataRole)).Str::random(6);
            $status = true;
            $response_code = "RC200";
            $message = "Anda Berhasil Load Data Detail Role User !!";

            return $this->onResult($status, $response_code, $message, $dataAPI);
        }else {
            $response_code = "RC400";
            $message = "Apakah Anda Robot Ingin Masuk Kedalam Sistem..!!";
            return $this->onResult($status, $response_code, $message, $dataAPI);
        }
    }

    public function act_editManagementRole(Request $request)
    {
        $status = false;
        $response_code = 'RC400';
        $message = 'Data Gagal Terjadi Gangguan..';
        $dataAPI = null;

        // wajib menggunakan request ajax
        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'form_role_uuid' => 'required',
                'form_role_nama' => 'required',
                'form_role_deskripsi' => 'required',
            ]);

            // Ketika data kiriman tidak sesuai
            if ($validator->fails())
            {
                $response_code = "RC400";
                $message = "Form Tidak Tervalidasi Dengan Sistem..!!";
                return $this->onResult($status, $response_code, $message, $dataAPI);
            }

            // Cek Data Menu Dalam Database
            $checkExistingDataRole =  mRoles::where('uuid', $request->form_role_uuid)->first(); 
            if(!$checkExistingDataRole)
            {
                $response_code = "RC401";
                $message = "Data Role User Tidak Ada Dalam Sistem";
                return $this->onResult($status, $response_code, $message, $dataAPI);
            }

            $checkExistingDataRole->name = $request->form_role_nama;
            $checkExistingDataRole->description = $request->form_role_deskripsi;

            $checkExistingDataRole->save();

            $status = true;
            $response_code = 'RC200';
            $message = 'Data menu berhasil diupdate, terimakasih !';
            $dataAPI = null;

            return $this->onResult($status, $response_code, $message, $dataAPI);
        }else {
            $response_code = "RC400";
            $message = "Apakah Anda Robot Ingin Masuk Kedalam Sistem..!!";
            return $this->onResult($status, $response_code, $message, $dataAPI);
        }
    }

    public function act_editstatusManagementRole(Request $request)
    {
        $status = false;
        $response_code = 'RC400';
        $message = 'Data Gagal Terjadi Gangguan..';
        $dataAPI = null;

        // wajib menggunakan request ajax
        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'data_id' => 'required',
                'data_status' => 'required',
            ]);

            // Ketika data kiriman tidak sesuai
            if ($validator->fails())
            {
                $response_code = "RC400";
                $message = "Form Tidak Tervalidasi Dengan Sistem..!!";
                return $this->onResult($status, $response_code, $message, $dataAPI);
            }

            // Cek Data Menu Dalam Database
            $checkExistingDataRole =  mRoles::where('uuid', $request->data_id)->first(); 
            if(!$checkExistingDataRole)
            {
                $response_code = "RC401";
                $message = "Data Role User Tidak Ada Dalam Sistem";
                return $this->onResult($status, $response_code, $message, $dataAPI);
            }
            
            $role_status = 0;

            if($request->data_status == "aktivasi")
            {
                $role_status = 1;
            }

            $checkExistingDataRole->status = $role_status;
            $checkExistingDataRole->save();

            $status = true;
            $response_code = 'RC200';
            $message = 'Data menu berhasil diupdate, terimakasih !';
            $dataAPI = null;

            return $this->onResult($status, $response_code, $message, $dataAPI);
        }else {
            $response_code = "RC400";
            $message = "Apakah Anda Robot Ingin Masuk Kedalam Sistem..!!";
            return $this->onResult($status, $response_code, $message, $dataAPI);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function page_hakaksesManagementRole(Request $request, $data_role){
        $model['route'] = 'Management Role Akses';

        $model['msrole'] = mRoles::where('uuid',$data_role)->first();
        
        if(!$model['msrole'])
        {
            return redirect()->back()->withErrors(['error_message' => 'Role User Tidak Terdaftar Dalam Sistem'])->with('alert-type', 'error');
        }

        $model['MsMenu'] = mMenu::with(['mMenuGrup' => function ($query) {
            $query->orderBy('sort', 'asc');
        }])
        ->get();

        $model['MsAuthhorization'] = vMenuAuthorization::where('id_role', $model['msrole']->id)->get();

        return view('pages.management-role.v_roleakses', ['model' => $model]);
    }

    public function act_hakaksesManagementRole(Request $request)
    {
        $status = false;
        $response_code = 'RC400';
        $message = 'Data Gagal Terjadi Gangguan..';
        $dataAPI = null;

        // wajib menggunakan request ajax
        if ($request->ajax()) {
            // dd($request->all());
            $validator = Validator::make($request->all(), [
                'role_aksesuser' => 'required',
                'switchStatus' => 'required',
                'menuAuth' => 'required',
                'menuID' => 'required'
            ]);

            // Ketika data kiriman tidak sesuai
            if ($validator->fails())
            {
                $response_code = "RC400";
                $message = "Form Tidak Tervalidasi Dengan Sistem..!!";
                return $this->onResult($status, $response_code, $message, $dataAPI);
            }

            $menuAuthacc = null;
            if($request->menuAuth == 'auth_view')
            {
                $menuAuthacc = 'authorization_view';
            }
            if($request->menuAuth == 'auth_create')
            {
                $menuAuthacc = 'authorization_create';
            }
            if($request->menuAuth == 'auth_update')
            {
                $menuAuthacc = 'authorization_update';
            }
            if($request->menuAuth == 'auth_delete')
            {
                $menuAuthacc = 'authorization_delete';
            }

            $statusAuthacc = 1;
            if($request->switchStatus == 'false')
            {
                $statusAuthacc = 0;
            }

            // Cek Data Role Dalam Database
            $checkExistingDataRole =  mRoles::where('uuid', $request->role_aksesuser)->first(); 
            if(!$checkExistingDataRole)
            {
                $response_code = "RC401";
                $message = "Data Role User Tidak Ada Dalam Sistem";
                return $this->onResult($status, $response_code, $message, $dataAPI);
            }

            // Cek Data Menu Dalam Database
            $checkExistingDatMenu =  mMenu::where('menu_uuid', $request->menuID)->first(); 
            if(!$checkExistingDatMenu)
            {
                $response_code = "RC401";
                $message = "Data Menu Tidak Ada Dalam Sistem";
                return $this->onResult($status, $response_code, $message, $dataAPI);
            }
            // dd($checkExistingDatMenu);

            $checkExistingDataAuth = mAuthorization::where('id_menu', $checkExistingDatMenu->id)->where('id_role', $checkExistingDataRole->id)->first();
            // dd($checkExistingDataAuth);

            $checkExistingDataAuthParent = mAuthorization::where('id_menu', $checkExistingDatMenu->menu_parent)->where('id_role', $checkExistingDataRole->id)->first();

            if($checkExistingDataAuth)
            {
                // Data Authorization Ketika Sudah Ada
                $checkExistingDataAuth->$menuAuthacc = $statusAuthacc;

                if($statusAuthacc == 0 && $menuAuthacc == 'authorization_view')
                {
                    $checkExistingDataAuth->authorization_create = 0;
                    $checkExistingDataAuth->authorization_update = 0;
                    $checkExistingDataAuth->authorization_delete = 0;
                    $checkExistingDataAuth->authorization_status = 0;
                }

                if($statusAuthacc != 0 && $menuAuthacc != 'authorization_view')
                {
                    $checkExistingDataAuth->authorization_view = 1;
                }   

                $checkExistingDataAuth->updated_at = Carbon::now('Asia/Jakarta');
                $checkExistingDataAuth->updated_by = Auth::user()->id;

                $checkExistingDataAuth->save();

                $status = true;
                $response_code = 'RC200';
                $message = 'Data menu berhasil diupdate, terimakasih !';
                $dataAPI = null;

                return $this->onResult($status, $response_code, $message, $dataAPI);

            }else{
                // Data Authorization Ketika Belum Ada
                DB::beginTransaction();
                try {
                    $AddDBTransaksi = new mAuthorization();

                    $AddDBTransaksi->id_role = $checkExistingDataRole->id;
                    $AddDBTransaksi->id_menu = $checkExistingDatMenu->id;
                    $AddDBTransaksi->authorization_uuid = (string) Str::uuid();
                    $AddDBTransaksi->authorization_code = "AUTH-".Str::random(6);
                    
                    $AddDBTransaksi->$menuAuthacc = $statusAuthacc;
                    if($statusAuthacc != 0 && $menuAuthacc != 'authorization_view')
                    {
                        $AddDBTransaksi->authorization_view = 1;
                    }     

                    $AddDBTransaksi->authorization_status = 1;

                    $AddDBTransaksi->created_at = Carbon::now('Asia/Jakarta');
                    $AddDBTransaksi->created_by = Auth::user()->id;

                    $AddDBTransaksi->save();

                    // Insert Ketika Menu Parent Belum Ditambahkan
                    if(!$checkExistingDataAuthParent)
                    {
                        $AddDBTransaksiParent = new mAuthorization();

                        $AddDBTransaksiParent->id_role = $checkExistingDataRole->id;
                        $AddDBTransaksiParent->id_menu = $checkExistingDatMenu->menu_parent;
                        $AddDBTransaksiParent->authorization_uuid = (string) Str::uuid();
                        $AddDBTransaksiParent->authorization_code = "AUTH-".Str::random(6);  
                        $AddDBTransaksiParent->authorization_view = 1;
                        $AddDBTransaksiParent->authorization_status = 1;
                        $AddDBTransaksiParent->created_at = Carbon::now('Asia/Jakarta');
                        $AddDBTransaksiParent->created_by = Auth::user()->id;

                        $AddDBTransaksiParent->save();
                    }

                    DB::commit();

                    $status = true;
                    $response_code = "RC200";
                    $message = "Anda Berhasil Merubah Data Kedalam Sistem !!";

                    return $this->onResult($status, $response_code, $message, $dataAPI);

                } catch (\Throwable $error) {
                    DB::rollback();
                    Log::critical($error);

                    $response_code = "RC400";
                    $message = "Anda Gagal Menambahkan Data Kedalam Sistem !!";
                    return $this->onResult($status, $response_code, $message, $dataAPI);
                }
            }
        }else {
            $response_code = "RC400";
            $message = "Apakah Anda Robot Ingin Masuk Kedalam Sistem..!!";
            return $this->onResult($status, $response_code, $message, $dataAPI);
        }
    }

    private static function onResult($status, $response_code, $message, $data)
    {
        $model['status'] = $status;
        $model['response_code'] = $response_code;
        $model['message'] = $message;
        $model['data'] = $data;
        return response()->json($model, 200);
    }
}
