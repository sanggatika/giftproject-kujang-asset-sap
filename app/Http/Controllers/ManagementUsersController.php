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
use Yajra\DataTables\Facades\DataTables;

use Carbon\Carbon;
use App\Rules\ReCaptcha;
use App\Http\Controllers\Helpers\mainController;

// Database
use Illuminate\Support\Facades\DB;
use App\Models\mRoles;
use App\Models\mRolesUser;
use App\Models\User;

class ManagementUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function page_indexManagementUsers(Request $request){
        $model['route'] = 'Management Users';
        
        $model['msrole'] = mRoles::where('status', 1)->get();
        if(Auth::user()->role_id != 1)
        {
            $model['msrole'] = mRoles::where('status', 1)->where('uuid', '!=', '28cce0f0-f0ba-4c7f-aa30-b5b04ee3e538')->get();
        }

        return view('pages.management-users.v_index', ['model' => $model]);
    }

    public function get_datatableManagementUsers(Request $request)
    {
        $status = false;
        $response_code = 'RC400';
        $message = 'Data Gagal Disimpan Terjadi Gangguan..';
        $dataAPI = null;
        
        if ($request->ajax()) {
            
            $form_filter_username = $request->form_filter_username;
            $form_filter_nama = $request->form_filter_nama;
            $form_filter_role = $request->form_filter_role;
            $form_filter_status = $request->form_filter_status;

            $dataMsusers = User::with('mRoles')->whereNotNull('uuid');
            
            if(Auth::user()->role_id != 1)
            {
                $dataMsusers->where('role_id', '!=', 1);
            }

            // Filter Data
            if($form_filter_username != "")
            {
                $dataMsusers->where('username', 'like', '%'.$form_filter_username.'%');
            }

            if($form_filter_nama != "")
            {
                $dataMsusers->where('nama', 'like', '%'.$form_filter_nama.'%');
            }

            if($form_filter_role != "-")
            {
                $dataMsusers->where('role_id', $form_filter_role);
            }

            if($form_filter_status != "-")
            {
                $dataMsusers->where('status', $form_filter_status);
            }

            $data = $dataMsusers->get();
            return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('fild_img', function($row)
            {
                $html = '<img src="'.asset("media/logos/206876.png").'" class="w-50px ms-n1" alt="">';

                return $html;
            })
            ->addColumn('fild_username', function($row)
            {
                $html = '<span class="text-gray-800 fw-bolder d-block fs-6">'.$row->username.'</span>';

                return $html;
            })
            ->addColumn('fild_nama', function($row)
            {                
                $html = '
                <!--begin::User details-->
                <div class="d-flex flex-column">
                    <a href="#" class="text-gray-800 text-hover-primary mb-1">'.$row->name.'</a>
                </div>
                <!--begin::User details-->
                ';

                return $html;
            })
            ->addColumn('fild_role', function($row)
            {
                $html = '<span class="badge badge-light-info badge-lg">'.$row->mRoles->name.'</span>';

                return $html;
            })
            ->addColumn('fild_status', function($row)
            {
                if($row->status == 1)
                {
                    $html = '<span class="badge badge-light-info badge-lg">Aktif</span>';
                }else{
                    $html = '<span class="badge badge-light-danger badge-lg">Non-aktif</span>';
                }

                return $html;
            })
            ->addColumn('fild_lastlogin', function($row)
            {
                $html = '
                <!--begin::User details-->
                <div class="d-flex flex-column">
                    <a href="#" class="text-gray-800 text-hover-primary mb-1">'.$row->last_login.'</a>
                </div>
                <!--begin::User details-->
                ';

                return $html;
            })
            ->addColumn('action', function($row)
            {
                $html = '
                <div class="d-flex align-items-center">
                    <button class="btn btn-primary me-2 p-2" data-toggle="detail" data-id="'.$row->uuid.'" onclick="act_btnDetailDataUser(this)" data-bs-toggle="tooltip" data-bs-placement="top" title="Detail User">
                        <i class="bi bi-person-check fs-4 mx-2"></i>
                    </button> 

                    <button class="btn btn-primary me-2 p-2" data-toggle="update" data-id="'.$row->uuid.'" onclick="act_btnUpdateDataUser(this)" data-bs-toggle="tooltip" data-bs-placement="top" title="Update User">
                        <i class="bi bi-person-gear fs-4 mx-2"></i>
                    </button>
                    
                    <button class="btn btn-primary me-2 p-2" data-toggle="update_pass" data-id="'.$row->uuid.'" onclick="act_btnUpdatePassDataUser(this)" data-bs-toggle="tooltip" data-bs-placement="top" title="Change Password User">
                        <i class="bi bi-person-fill-lock fs-4 mx-2"></i>
                    </button>                               
                
                ';

                if($row->status == 1)
                {
                    $html .= '
                    <button class="btn btn-danger me-2 p-2" data-id="'.$row->uuid.'" data-nama="'.$row->name.'" data-status="nonaktif" onclick="acttion_UpdateStatusDataUser(this)" data-bs-toggle="tooltip" data-bs-placement="top" title="Non-Aktif User">
                        <i class="bi bi-person-slash fs-4 mx-2"></i>
                    </button>
                    ';
                }else{
                    $html .= '
                    <button class="btn btn-primary me-2 p-2" data-id="'.$row->uuid.'" data-nama="'.$row->name.'" data-status="aktivasi" onclick="acttion_UpdateStatusDataUser(this)" data-bs-toggle="tooltip" data-bs-placement="top" title="Aktivasi User">
                        <i class="bi bi-person-slash fs-4 mx-2"></i>
                    </button>
                    ';
                }

                $html .='</div>';

                return $html;
            })
            ->rawColumns(['fild_img','fild_username','fild_nama', 'fild_role', 'fild_status', 'fild_lastlogin', 'action'])
            ->make(true);
        }
        return $this->onResult($status, $response_code, $message, $dataAPI);
    }

    public function act_tambahManagementUsers(Request $request)
    {
        $status = false;
        $response_code = 'RC400';
        $message = 'Data Gagal Disimpan Terjadi Gangguan..';
        $dataAPI = null;

        if ($request->ajax()) {  
            // dd($request->all());          
            $validator = Validator::make($request->all(), [
                'form_useradm_nama' => 'required',
                'form_useradm_email' => 'required',
                'form_useradm_password' => 'required',
                'form_useradm_role' => 'required',
                'g-recaptcha-response' => ['required', new ReCaptcha]
            ]);

            // Ketika data kiriman tidak sesuai
            if ($validator->fails())
            {
                $response_code = "RC400";
                $message = "Form Tidak Tervalidasi Dengan Sistem";
                return $this->onResult($status, $response_code, $message, $dataAPI);
            }

            // validasi controller check password
            if(mainController::checkStrengthPassword($request->form_useradm_password) == false)
            {
                $response_code = "RC401";
                $message = "Password Belum Memenuhi Standar Keamanan";
                return $this->onResult($status, $response_code, $message, $dataAPI);
            }

            // Cek Data User Dalam Database
            $checkExistingDataUser =  User::where('email', $request->form_useradm_email)->first();

            if($checkExistingDataUser)
            {
                $response_code = "RC400";
                $message = "Email atau Username Sudah Pernah Digunakan";
                return $this->onResult($status, $response_code, $message, $dataAPI);
            }

            // Validasi Ketika Gagal Melakukan Transaksi Data Akan Di Rollback
            DB::beginTransaction();

            try {
                // Proses Simpan User Kedalam Database
                $params_user = [
                    'uuid' => (string) Str::uuid(),
                    'role_id' => $request->form_useradm_role,
                    'name' => $request->form_useradm_nama,
                    'email' => $request->form_useradm_email,
                    'username' => $request->form_useradm_email,                   
                    'password' => Hash::make($request->form_useradm_password),
                    'status' => 1,
                    'email_verified' => 1,
                    'email_verified_at' => Carbon::now(),
                    'created_at' => Carbon::now(),                    
                    'created_by' => 'Admin Registration',                    
                ];
                $user_id = User::insertGetId($params_user);
                
                // Proses Simpan Role User Kedalam Database
                $AddRoleUser = new mRolesUser();

                $AddRoleUser->uuid =  (string) Str::uuid();
                $AddRoleUser->role_id =  $request->form_useradm_role;
                $AddRoleUser->user_id =  $user_id;
                $AddRoleUser->status =  1;
                $AddRoleUser->created_at = Carbon::now();
                $AddRoleUser->updated_at = Carbon::now();

                $AddRoleUser->save();

                DB::commit();

                $status = true;
                $response_code = "RC200";
                $message = "Anda Berhasil Register User Admin !!";

                return $this->onResult($status, $response_code, $message, $dataAPI);                
            } catch (\Throwable $error) {
                DB::rollback();
                Log::critical($error);

                $response_code = "RC400";
                $message = "Anda Gagal Menambahkan Data Kedalam Sistem !!" .$error;
                return $this->onResult($status, $response_code, $message, $dataAPI);
            }
        }
        return $this->onResult($status, $response_code, $message, $dataAPI);
    }

    public function act_detailManagementUsers(Request $request)
    {
        $status = false;
        $response_code = 'RC400';
        $message = 'Data Gagal Disimpan Terjadi Gangguan..';
        $dataAPI = null;

        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'data_id' => 'required',
            ]);

            // Ketika data kiriman tidak sesuai
            if ($validator->fails())
            {
                $response_code = "RC400";
                $message = "Form Tidak Tervalidasi Dengan Sistem";
                return $this->onResult($status, $response_code, $message, $dataAPI);
            }

            // Cek Data User Dalam Database
            $checkExistingDataUser =  User::where('uuid', $request->data_id)->first();

            if(!$checkExistingDataUser)
            {
                $response_code = "RC400";
                $message = "Data User Tidak Ada Dalam Sistem";
                return $this->onResult($status, $response_code, $message, $dataAPI);
            }

            $dataAPI = $checkExistingDataUser;
            $status = true;
            $response_code = "RC200";
            $message = "Anda Berhasil Load Data User Admin !!";
        }
        return $this->onResult($status, $response_code, $message, $dataAPI);
    }

    public function act_updateManagementUsers(Request $request)
    {
        $status = false;
        $response_code = 'RC400';
        $message = 'Data Gagal Disimpan Terjadi Gangguan..';
        $dataAPI = null;

        if ($request->ajax()) {
            // dd($request->all());
            $validator = Validator::make($request->all(), [
                'form_useradm_code' => 'required',
                'form_useradm_act' => 'required',
                'g-recaptcha-response' => ['required', new ReCaptcha]
            ]);

            // Ketika data kiriman tidak sesuai
            if ($validator->fails())
            {
                $response_code = "RC400";
                $message = "Form Tidak Tervalidasi Dengan Sistem";
                return $this->onResult($status, $response_code, $message, $dataAPI);
            }

            // Cek Data User Dalam Database
            $checkExistingDataUser =  User::where('uuid', $request->form_useradm_code)->first();
            // dd($checkExistingDataUser);

            if(!$checkExistingDataUser)
            {
                $response_code = "RC400";
                $message = "Data User Tidak Ada Dalam Sistem";
                return $this->onResult($status, $response_code, $message, $dataAPI);
            }

            if($request->form_useradm_act == 'update_data')
            {
                $param = [
                    'name' => $request->form_useradm_nama,
                    'role_id' => $request->form_useradm_role
                ];
            }

            if($request->form_useradm_act == 'update_pass')
            {
                // validasi controller check password
                if(mainController::checkStrengthPassword($request->form_useradm_password) == false)
                {
                    $response_code = "RC401";
                    $message = "Password Belum Memenuhi Standar Keamanan";
                    return $this->onResult($status, $response_code, $message, $dataAPI);
                }

                $param = [
                    'password' => Hash::make($request->form_useradm_password),
                ];
            }

            try {
                User::where('uuid', $request->form_useradm_code)
                ->update($param);

                if($request->form_useradm_act == 'update_data')
                {
                    mRolesUser::where('user_id', $checkExistingDataUser->id)
                    ->update(['role_id' => $request->form_useradm_role]);
                }                

                $status = true;
                $response_code = "RC200";
                $message = "Anda Berhasil Update Data User Admin !!";

                return $this->onResult($status, $response_code, $message, $dataAPI);                
            } catch (\Throwable $error) {
                Log::critical($error);

                $response_code = "RC400";
                $message = "Anda Gagal Update Data Kedalam Sistem !!" .$error;
                return $this->onResult($status, $response_code, $message, $dataAPI);
            }           
            
        }
        return $this->onResult($status, $response_code, $message, $dataAPI);
    }

    public function act_update_statusManagementUsers(Request $request)
    {
        $status = false;
        $response_code = 'RC400';
        $message = 'Data Gagal Disimpan Terjadi Gangguan..';
        $dataAPI = null;

        if ($request->ajax()) {
            // dd($request->all());
            $validator = Validator::make($request->all(), [
                'data_id' => 'required',
                'data_nama' => 'required',
                'data_status' => 'required',
            ]);

            // Ketika data kiriman tidak sesuai
            if ($validator->fails())
            {
                $response_code = "RC400";
                $message = "Form Tidak Tervalidasi Dengan Sistem";
                return $this->onResult($status, $response_code, $message, $dataAPI);
            }

            // Cek Data User Dalam Database
            $checkExistingDataUser =  User::where('uuid', $request->data_id)->first();

            if(!$checkExistingDataUser)
            {
                $response_code = "RC400";
                $message = "Data User Tidak Ada Dalam Sistem";
                return $this->onResult($status, $response_code, $message, $dataAPI);
            }

            if($request->data_status == 'nonaktif')
            {
                $param = [
                    'status' => 0,
                ];
            }

            if($request->data_status == 'aktivasi')
            {
                $param = [
                    'status' => 1,
                ];
            }

            try {

                User::where('uuid', $request->data_id)
                ->update($param);                

                $status = true;
                $response_code = "RC200";
                $message = "Anda Berhasil Update Data User Admin !!";

                return $this->onResult($status, $response_code, $message, $dataAPI);                
            } catch (\Throwable $error) {
                Log::critical($error);

                $response_code = "RC400";
                $message = "Anda Gagal Menambahkan Data Kedalam Sistem !!" .$error;
                return $this->onResult($status, $response_code, $message, $dataAPI);
            }           
            
        }
        return $this->onResult($status, $response_code, $message, $dataAPI);
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
