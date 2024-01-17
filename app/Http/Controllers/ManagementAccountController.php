<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

use Carbon\Carbon;
use App\Rules\ReCaptcha;
use App\Http\Controllers\Helpers\mainController;

// Database
use App\Models\User;

class ManagementAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function page_indexManagementAccount(Request $request)
    {
        $model['route'] = 'Dashboard Admin';

        $model['msuser'] = User::where('id', Auth::user()->id)->first();

        return view('pages.management-account.v_index', ['model' => $model]);
    }

    public function act_updatePasswordManagementAccount(Request $request)
    {
        $status = false;
        $response_code = 'RC400';
        $message = 'Data Gagal Disimpan Terjadi Gangguan..';
        $dataAPI = null;

        if ($request->ajax()) {
            // dd($request->all());
            $validator = Validator::make($request->all(), [
                'form_useradm_password_current' => 'required',
                'form_useradm_password' => 'required',
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
            $checkExistingDataUser =  User::where('id', Auth::user()->id)->first();
            // dd($checkExistingDataUser);

            if(!$checkExistingDataUser)
            {
                $response_code = "RC400";
                $message = "Data User Tidak Ada Dalam Sistem";
                return $this->onResult($status, $response_code, $message, $dataAPI);
            }

            if(Hash::check($request->form_useradm_password_current, $checkExistingDataUser->password) == false)
            {
                $response_code = "RC401";
                $message = "Data Password Saat Ini Tidak Sesuai !!";
                return $this->onResult($status, $response_code, $message, $dataAPI);
            }

            if($request->form_useradm_password_current == $request->form_useradm_password)
            {
                $response_code = "RC401";
                $message = "Data Password Baru Tidak Boleh Sama dengan Password Sebelumnya";
                return $this->onResult($status, $response_code, $message, $dataAPI);
            }
            
            $param = [
                'password' => Hash::make($request->form_useradm_password),
            ];

            try {
                User::where('uuid', $request->form_useradm_code)
                ->update($param);               

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

    
    private static function onResult($status, $response_code, $message, $data)
    {
        $model['status'] = $status;
        $model['response_code'] = $response_code;
        $model['message'] = $message;
        $model['data'] = $data;
        return response()->json($model, 200);
    }
}
