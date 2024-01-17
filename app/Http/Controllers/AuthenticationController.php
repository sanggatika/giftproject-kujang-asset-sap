<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

use Carbon\Carbon;
use App\Rules\ReCaptcha;
use App\Http\Controllers\Helpers\mainController;

//Conect to DB
use Illuminate\Support\Facades\DB;
use App\Models\LogLogin;
use App\Models\User;
use App\Models\PasswordReset;
use App\Models\mRolesUser;
use App\Models\UserVerifies;


class AuthenticationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function page_loginAuthentication()
    {        
        if(Auth::check())
        {
            return redirect('/');
        }else {
            $model['route'] = 'auth';
            return view('pages.auth.signin', ['model' => $model]);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function page_registerAuthentication()
    {        
        if(Auth::check())
        {
            return redirect('/');
        }else {
            $model['route'] = 'auth';
            return view('pages.auth.signup', ['model' => $model]);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function page_forgotAuthentication()
    {        
        if(Auth::check())
        {
            return redirect('/');
        }else {
            $model['route'] = 'auth';
            return view('pages.auth.reset-password', ['model' => $model]);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function page_resetpasswordAuthentication($token)
    {        
        if(Auth::check())
        {
            return redirect('/');
        }else {
            if(!$token)
            {
                return redirect('/auth/login');
            }

            $is_valid = [
                'status' => true,
                'reason' => 'token_valid'
            ];

            // Cek Token
            $checkToken =  PasswordReset::where('token', $token)->first();
            // dd($checkToken);

            $model['token'] = null;

            // validasi token
            if(!$checkToken)
            {
                $is_valid['status'] = false;
                $is_valid['reason'] = 'token_invalid';
            }else{
                if($checkToken->status == 1)
                {
                    $is_valid['status'] = false;
                    $is_valid['reason'] = 'token_sudah_digunakan';
                }

                if($checkToken->status == -1)
                {
                    $is_valid['status'] = false;
                    $is_valid['reason'] = 'token_expired';
                }else{
                    if ((Carbon::parse($checkToken->created_at)->addMinutes(env("MAX_TOKEN_EMAIL_EXPIRED", 15)) >= Carbon::now()) == false) {
                        $is_valid['status'] = false;
                        $is_valid['reason'] = 'token_expired';
    
                        $checkToken->status = '-1';
                        $checkToken->save();
                    } 
                }

                $model['token'] = $checkToken->token;
            };

            $model['route'] = 'auth';
            $model['vilid_token'] = $is_valid;
            return view('pages.auth.new-password', ['model' => $model]);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function page_twofactorAuthentication($token)
    {        
        if(Auth::check())
        {
            return redirect('/');
        }else {
            if(!$token)
            {
                return redirect('/auth/login');
            }

            $is_valid = [
                'status' => true,
                'reason' => 'token_valid'
            ];

            // Cek Token
            $checkToken =  UserVerifies::where('token', $token)->orderBy('id', 'desc')->first();
            // dd($checkToken);

            $model['token'] = null;

            // validasi token
            if(!$checkToken)
            {
                $is_valid['status'] = false;
                $is_valid['reason'] = 'token_invalid';
            }else{
                if($checkToken->status == 1)
                {
                    $is_valid['status'] = false;
                    $is_valid['reason'] = 'token_sudah_digunakan';
                }

                if($checkToken->status == -1)
                {
                    $is_valid['status'] = false;
                    $is_valid['reason'] = 'token_expired';
                }                
            };

            $model['email'] = $checkToken->email;
            $model['token'] = $checkToken->token;
            $model['vilid_token'] = $is_valid;

            $model['route'] = 'auth';
            return view('pages.auth.two-factor', ['model' => $model]);
        }
    }

    public function act_loginAuthentication(Request $request)
    {
        $status = false;
        $response_code = 'RC400';
        $message = 'Data Gagal Terjadi Gangguan..';
        $dataAPI = null;

        $clientAgent = mainController::getClientAgent();
        // dd($clientAgent);

        // wajib menggunakan request ajax
        if ($request->ajax()) {
            sleep(2);
            // dd($request->all());
            $validator = Validator::make($request->all(), [
                'username' => 'required',
                'password' => 'required',
                'recaptcha' => ['required', new ReCaptcha]
            ]);

            Log::critical('login Aplikasi '.env('APP_NAME').' username : '.$request->username.' url : '.url('/').' ip : '.request()->server('SERVER_ADDR'). ' akses : '.request()->ip());

            // Ketika data kiriman tidak sesuai
            if ($validator->fails())
            {
                Log::critical($validator->errors());
                $response_code = "RC400";
                $message = "Form Tidak Tervalidasi Dengan Sistem..!!";
                return $this->onResult($status, $response_code, $message, $dataAPI);
            }

            // set kebutuhan parameter
            $credentials = $request->only('username', 'password');
            $ipAddress = $request->ip();
            $interval = Carbon::now()->subMinutes(15)->toDateTimeString();
            $username = null;
            if($request->has('username'))
            {
                $username = $request->username;
            }

            $whereLoginFirst = LogLogin::where('status', '0')
            ->where(function ($query) use ($ipAddress, $username) {
                $query->where('ip_address', $ipAddress);
                $query->orWhere('username', $username);
            })
            ->where('browser', $clientAgent['browser'])
            ->where('browser_version', $clientAgent['browser_version'])
            ->where('created_at', '>=', $interval);

            $maxLoginAttempt = env("MAX_LOGIN_ATTEMPT", 5);
            if ($whereLoginFirst->count() >= $maxLoginAttempt) {
                $lastAttempLogin = Carbon::parse($whereLoginFirst->latest()->first()->created_at);
                $lastAttempLoginAfterInterval = $lastAttempLogin->addMinutes(env("MAX_LOGIN_TIME", 15));
                $different = Carbon::now()->diff($lastAttempLoginAfterInterval)->format('%i');
                
                $message = "Maaf, anda harus menunggu selama {$different} menit untuk bisa login kembali.";
                return $this->onResult($status, $response_code, $message, $dataAPI);
            }

            // username dan password tidak sesuai
            if (!Auth::attempt(['username' => $request->username, 'password' => $request->password])) :
                $dataLog = [
                    'uuid' => (string) Str::uuid(),
                    'username' => $request->username,
                    'keterangan' => "Mencoba untuk login - username password tidak sesuai",
                    'ip_address' => $ipAddress,
                    'browser' => $clientAgent['browser'],
                    'browser_version' => $clientAgent['browser_version'],
                    'platform' => $clientAgent['platform'],
                    'device' => $clientAgent['device'],
                    'desktop' => $clientAgent['desktop'],
                    'phone' => $clientAgent['phone'],
                    'robot' => $clientAgent['robot'],
                    'status' => 0,
                    'created_at' => Carbon::now()
                ];
                LogLogin::insert($dataLog);

                $message = "<b>Kombinasi Username dan Password anda salah. </b><br>Anda memiliki " . ($maxLoginAttempt - $whereLoginFirst->count()) . " kali kesempatan lagi untuk mencoba masuk ke sistem.";
                return $this->onResult($status, $response_code, $message, $dataAPI);
            endif;

            // user status aktif
            if (Auth::user()->email_verified == 0) :
                $dataLog = [
                    'uuid' => (string) Str::uuid(),
                    'username' => $request->username,
                    'keterangan' => "Mencoba untuk login - user not verified",
                    'ip_address' => $ipAddress,
                    'browser' => $clientAgent['browser'],
                    'browser_version' => $clientAgent['browser_version'],
                    'platform' => $clientAgent['platform'],
                    'device' => $clientAgent['device'],
                    'desktop' => $clientAgent['desktop'],
                    'phone' => $clientAgent['phone'],
                    'robot' => $clientAgent['robot'],
                    'status' => 0,
                    'created_at' => Carbon::now()
                ];
                LogLogin::insert($dataLog);
                
                Auth::logout();
                $message = "<b>User belum melakukan verifikasi email </b> <br>Anda memiliki " . ($maxLoginAttempt - $whereLoginFirst->count()) . " kali kesempatan lagi untuk mencoba masuk ke sistem.";
                return $this->onResult($status, $response_code, $message, $dataAPI);
            endif;

            // user status aktif
            if (Auth::user()->status == 0) :
                $dataLog = [
                    'uuid' => (string) Str::uuid(),
                    'username' => $request->username,
                    'keterangan' => "Mencoba untuk login - user status tidak aktif",
                    'ip_address' => $ipAddress,
                    'browser' => $clientAgent['browser'],
                    'browser_version' => $clientAgent['browser_version'],
                    'platform' => $clientAgent['platform'],
                    'device' => $clientAgent['device'],
                    'desktop' => $clientAgent['desktop'],
                    'phone' => $clientAgent['phone'],
                    'robot' => $clientAgent['robot'],
                    'status' => 0,
                    'created_at' => Carbon::now()
                ];
                LogLogin::insert($dataLog);
                
                Auth::logout();
                $message = "<b>User anda saat ini tidak aktif</b> <br>Anda memiliki " . ($maxLoginAttempt - $whereLoginFirst->count()) . " kali kesempatan lagi untuk mencoba masuk ke sistem.";
                return $this->onResult($status, $response_code, $message, $dataAPI);
            endif;

            $whereLoginFirst->update(['status' => 99]);
            $dataLog = [
                'uuid' => (string) Str::uuid(),
                'username' => $request->username,
                'keterangan' => "Berhasil Login",
                'ip_address' => $ipAddress,
                'browser' => $clientAgent['browser'],
                'browser_version' => $clientAgent['browser_version'],
                'platform' => $clientAgent['platform'],
                'device' => $clientAgent['device'],
                'desktop' => $clientAgent['desktop'],
                'phone' => $clientAgent['phone'],
                'robot' => $clientAgent['robot'],
                'status' => 1,
                'created_at' => Carbon::now()
            ];
            LogLogin::insert($dataLog);

            // set auth user
            $user = Auth::getProvider()->retrieveByCredentials($credentials);
            Auth::login($user);

            // ketika langsung akses halaman tertentu
            $this->authenticated($request, $user);

            try {
                // Validate the value...
                // Get the updated rows count here. Keep in mind that zero is a
                // valid value (not failure) if there were no updates needed
                DB::table('users')->where('id', Auth::user()->id)->update([
                    'last_login' => Carbon::now()
                ]);
            } catch (\Throwable $error) {
                Log::critical($error);
         
                $response_code = "RC400";
                $message = "Sistem dagal login, Kesalahan update data last login !!";
                return $this->onResult($status, $response_code, $message, $dataAPI);
            }

            $status = true;
            $response_code = 'RC200';
            $message = 'Terimakasih, Anda Berhasil Masuk Aplikasi..';
            $dataAPI = null;
            
            return $this->onResult($status, $response_code, $message, $dataAPI);
        }else {
            $response_code = "RC400";
            $message = "Apakah Anda Robot Ingin Masuk Kedalam Sistem..!!";
            return $this->onResult($status, $response_code, $message, $dataAPI);
        }
    }

    public function act_forgotAuthentication(Request $request)
    {
        $status = false;
        $response_code = 'RC400';
        $message = 'Data Gagal Terjadi Gangguan..';
        $dataAPI = null;

        // $clientAgent = mainController::getClientAgent();
        // dd($clientAgent);

        // wajib menggunakan request ajax
        if ($request->ajax()) {
            sleep(2);
            // dd($request->all());
            $validator = Validator::make($request->all(), [
                'username' => 'required',
                'recaptcha' => ['required', new ReCaptcha]
            ]);

            // Ketika data kiriman tidak sesuai
            if ($validator->fails())
            {
                $response_code = "RC400";
                $message = "Form Tidak Tervalidasi Dengan Sistem..!!";
                return $this->onResult($status, $response_code, $message, $dataAPI);
            }

            // Cek Data User Dalam Database
            $checkExistingDataUser =  User::where('email', $request->username)->first();

            if(!$checkExistingDataUser)
            {
                $response_code = "RC400";
                $message = "Email atau Username Tidak Terdaftar Dalam Sistem";
                return $this->onResult($status, $response_code, $message, $dataAPI);
            }

            // Cek Reset Password
            $checkResetPassword =  PasswordReset::where('email', $request->username)->where('status', 0)->orderBy('created_at', 'desc')->first();

            if ($checkResetPassword) {
                $start = Carbon::parse($checkResetPassword->created_at);
                $now = Carbon::now();
                $selisih = $start->diffInMinutes($now);
                
                $limit = (int) env("MAX_TOKEN_EMAIL_RESEND", 5);
                
                if ($limit > $selisih) {
                    $response_code = "RC400";
                    $message = "Tidak dapat mengirim email, silahkan tunggu " . ($limit - $selisih) . " menit untuk meminta email baru. Atau cek email anda pada kotak masuk dan spam untuk melanjutkan proses reset password.";
                    return $this->onResult($status, $response_code, $message, $dataAPI);
                }
            }

            $email = $checkExistingDataUser->email;

            $token = Str::random(64);

            DB::beginTransaction();

            try {
                // menyimpan data transaksi kedalam database
                $AddDBTransaksi = new PasswordReset();

                $AddDBTransaksi->uuid = (string) Str::uuid();
                $AddDBTransaksi->email = $email;
                $AddDBTransaksi->token = $token;
                $AddDBTransaksi->status = 0;
                $AddDBTransaksi->created_at = Carbon::now();

                $AddDBTransaksi->save();

                // proses kirim email
                $sendEmailData = [
                    'to' => $email,
                    'subject' => "Konfirmasi Reset Password",
                    'html' => view('pages.email.auth_resetpassword', [
                        'link' => url('auth/reset-password') . "/" . $token
                    ])->render(),
                ];
                
                $process_email  = mainController::sendEmailAWS($sendEmailData);

                if ($process_email['state'] == true) 
                {
                    DB::commit();

                    $status = true;
                    $response_code = 'RC200';
                    $message = 'Konfirmasi reset password berhasil dikirim ke email..';
                    $dataAPI = null;

                    return $this->onResult($status, $response_code, $message, $dataAPI);
                } else {
                    DB::rollback();                    

                    if(isset($process_email['message']))
                    {
                        Log::critical($process_email['message']);
                    }

                    if(isset($process_email['error']))
                    {
                        Log::critical($process_email['error']);
                    }

                    $response_code = "RC400";
                    $message = "Sistem gagal Kesalahan saat kirim email konfirmasi !!";
                    return $this->onResult($status, $response_code, $message, $dataAPI);
                }                               
            } catch (\Throwable $error) {
                DB::rollback();
                Log::critical($error);
                
                $response_code = "RC400";
                $message = "Sistem gagal proses data, Kesalahan saat kirim data !!";
                return $this->onResult($status, $response_code, $message, $dataAPI);
            }

        }else {
            $response_code = "RC400";
            $message = "Apakah Anda Robot Ingin Masuk Kedalam Sistem..!!";
            return $this->onResult($status, $response_code, $message, $dataAPI);
        }
    }

    public function act_resetAuthentication(Request $request)
    {
        $status = false;
        $response_code = 'RC400';
        $message = 'Data Gagal Terjadi Gangguan..';
        $dataAPI = null;

        // wajib menggunakan request ajax
        if ($request->ajax()) {
            sleep(2);
            $validator = Validator::make($request->all(), [
                'token' => 'required',
                'form_useradm_password' => 'required',
                'recaptcha' => ['required', new ReCaptcha]
            ]);

            // Ketika data kiriman tidak sesuai
            if ($validator->fails())
            {
                $response_code = "RC400";
                $message = "Form Tidak Tervalidasi Dengan Sistem..!!";
                return $this->onResult($status, $response_code, $message, $dataAPI);
            }

            // validasi controller check password
            if(mainController::checkStrengthPassword($request->form_useradm_password) == false)
            {
                $response_code = "RC401";
                $message = "Password Belum Memenuhi Standar Keamanan";
                return $this->onResult($status, $response_code, $message, $dataAPI);
            }

            // Cek Token
            $checkToken =  PasswordReset::where('token', $request->token)->first();

            if(!$checkToken)
            {
                $response_code = "RC400";
                $message = "Data token invalid";
                return $this->onResult($status, $response_code, $message, $dataAPI);
            }

            if($checkToken->status == 1)
            {
                $response_code = "RC400";
                $message = "Token sudah digunakan";
                return $this->onResult($status, $response_code, $message, $dataAPI);
            }

            if($checkToken->status == -1)
            {
                $response_code = "RC400";
                $message = "Token sudah expired";
                return $this->onResult($status, $response_code, $message, $dataAPI);
            }else{
                if ((Carbon::parse($checkToken->created_at)->addMinutes(env("MAX_TOKEN_EMAIL_EXPIRED", 15)) >= Carbon::now()) == false) 
                {
                    $response_code = "RC400";
                    $message = "Token sudah expired";
                    return $this->onResult($status, $response_code, $message, $dataAPI);
                } 
            }

            // Cek Data User Dalam Database
            $checkExistingDataUser =  User::where('email', $checkToken->email)->first();

            if(!$checkExistingDataUser)
            {
                $response_code = "RC400";
                $message = "Email atau Username Tidak Terdaftar Dalam Sistem";
                return $this->onResult($status, $response_code, $message, $dataAPI);
            }

            // dd($checkExistingDataUser);

            $params = [
                'password' => Hash::make($request->form_useradm_password),
                'updated_at' => Carbon::now()
            ];

            // proses update
            try {
                $checkToken->status = '1';
                $checkToken->save();

                // update user
                User::where('id', $checkExistingDataUser->id)
                ->update($params);

                $status = true;
                $response_code = "RC200";
                $message = "Anda Berhasil Update Password, silahkan login !!";
                $dataAPI = null;
        
                return $this->onResult($status, $response_code, $message, $dataAPI);
            } catch (\Throwable $error) {
                Log::critical($error);
        
                $response_code = "RC400";
                $message = "Gagal Update Data Kedalam Sistem !!";
                return $this->onResult($status, $response_code, $message, $dataAPI);
            }
        }else {
            $response_code = "RC400";
            $message = "Apakah Anda Robot Ingin Masuk Kedalam Sistem..!!";
            return $this->onResult($status, $response_code, $message, $dataAPI);
        }
    }

    public function act_registerAuthentication(Request $request)
    {
        $status = false;
        $response_code = 'RC400';
        $message = 'Data Gagal Terjadi Gangguan..';
        $dataAPI = null;

        // wajib menggunakan request ajax
        if ($request->ajax()) {
            sleep(2);
            // dd($request->all());
            $validator = Validator::make($request->all(), [
                'form_useradm_nama' => 'required',
                'form_useradm_email' => 'required',
                'form_useradm_password' => 'required',
                'recaptcha' => ['required', new ReCaptcha]
            ]);

            // Ketika data kiriman tidak sesuai
            if ($validator->fails())
            {
                $response_code = "RC400";
                $message = "Form Tidak Tervalidasi Dengan Sistem..!!";
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
                    'role_id' => 2,
                    'name' => $request->form_useradm_nama,
                    'email' => $request->form_useradm_email,
                    'username' => $request->form_useradm_email,                   
                    'password' => Hash::make($request->form_useradm_password),
                    'status' => 0,
                    'email_verified' => 0,
                    'email_verified_at' => null,
                    'created_at' => Carbon::now(),                    
                    'created_by' => 'Auth Registration',                    
                ];
                $user_id = User::insertGetId($params_user);
                
                // Proses Simpan Role User Kedalam Database
                $AddRoleUser = new mRolesUser();

                $AddRoleUser->uuid =  (string) Str::uuid();
                $AddRoleUser->role_id =  2;
                $AddRoleUser->user_id =  $user_id;
                $AddRoleUser->status =  1;
                $AddRoleUser->created_at = Carbon::now();
                $AddRoleUser->updated_at = Carbon::now();

                $AddRoleUser->save();

                // proses kirim email
                $token = Str::random(64);
                $pin = rand(100000,999999);

                $AddDBTransaksi = new UserVerifies();

                $AddDBTransaksi->uuid = (string) Str::uuid();
                $AddDBTransaksi->user_id = $user_id;
                $AddDBTransaksi->email = $request->form_useradm_email;
                $AddDBTransaksi->token = $token;
                $AddDBTransaksi->pin = $pin;
                $AddDBTransaksi->status = 0;
                $AddDBTransaksi->created_at = Carbon::now('Asia/Jakarta');

                $AddDBTransaksi->save();

                // proses kirim email
                $sendEmailData = [
                    // 'to' => $request->form_useradm_email,
                    'to' => 'sanggatika@gmail.com',
                    'subject' => "Verifikasi Akun Sistem",
                    'html' => view('pages.email.auth_verifyakun', [
                        'link' => url('auth/two-factor') . "/" . $token,
                        'pin' => $pin
                    ])->render(),
                ];
                
                $process_email  = mainController::sendEmailAWS($sendEmailData);

                if ($process_email['state'] == true) 
                {
                    DB::commit();

                    $status = true;
                    $response_code = 'RC200';
                    $message = 'Konfirmasi reset password berhasil dikirim ke email..';
                    $dataAPI = null;

                    return $this->onResult($status, $response_code, $message, $dataAPI);
                } else {
                    DB::rollback();                    

                    if(isset($process_email['message']))
                    {
                        Log::critical($process_email['message']);
                    }

                    if(isset($process_email['error']))
                    {
                        Log::critical($process_email['error']);
                    }

                    $response_code = "RC400";
                    $message = "Sistem gagal Kesalahan saat kirim email konfirmasi !!";
                    return $this->onResult($status, $response_code, $message, $dataAPI);
                }             
            } catch (\Throwable $error) {
                DB::rollback();
                Log::critical($error);

                $response_code = "RC400";
                $message = "Anda Gagal Menambahkan Data Kedalam Sistem !!" .$error;
                return $this->onResult($status, $response_code, $message, $dataAPI);
            }
        }else {
            $response_code = "RC400";
            $message = "Apakah Anda Robot Ingin Masuk Kedalam Sistem..!!";
            return $this->onResult($status, $response_code, $message, $dataAPI);
        }
    }

    public function act_twofactorAuthentication(Request $request)
    {
        $status = false;
        $response_code = 'RC400';
        $message = 'Data Gagal Terjadi Gangguan..';
        $dataAPI = null;

        // wajib menggunakan request ajax
        if ($request->ajax()) {
            sleep(2);

            $validator = Validator::make($request->all(), [
                'token' => 'required',
                'form_code_1' => 'required',
                'form_code_2' => 'required',
                'form_code_3' => 'required',
                'form_code_4' => 'required',
                'form_code_5' => 'required',
                'form_code_6' => 'required',
                'recaptcha' => ['required', new ReCaptcha]
            ]);

            // Ketika data kiriman tidak sesuai
            if ($validator->fails())
            {
                $response_code = "RC400";
                $message = "Form Tidak Tervalidasi Dengan Sistem..!!";
                return $this->onResult($status, $response_code, $message, $dataAPI);
            }           

            // Cek Token
            $checkToken =  UserVerifies::where('token', $request->token)->orderBy('id', 'desc')->first();

            if(!$checkToken)
            {
                $response_code = "RC400";
                $message = "Data token invalid";
                return $this->onResult($status, $response_code, $message, $dataAPI);
            }

            if($checkToken->status == 1)
            {
                $response_code = "RC400";
                $message = "Token sudah digunakan";
                return $this->onResult($status, $response_code, $message, $dataAPI);
            }

            if($checkToken->status == -1)
            {
                $response_code = "RC400";
                $message = "Token sudah expired";
                return $this->onResult($status, $response_code, $message, $dataAPI);
            }

            $pin = $request->form_code_1.$request->form_code_2.$request->form_code_3.$request->form_code_4.$request->form_code_5.$request->form_code_6;
            // dd($pin);

            if($checkToken->pin != $pin)
            {
                $response_code = "RC400";
                $message = "PIN Tidak Sesuai Dengan Sistem";
                return $this->onResult($status, $response_code, $message, $dataAPI);
            }

            // Cek Data User Dalam Database
            $checkExistingDataUser =  User::where('email', $checkToken->email)->first();

            if(!$checkExistingDataUser)
            {
                $response_code = "RC400";
                $message = "Email atau Username Tidak Terdaftar Dalam Sistem";
                return $this->onResult($status, $response_code, $message, $dataAPI);
            }

            // proses update
            try {
                $checkExistingDataUser->status = 1;
                $checkExistingDataUser->email_verified = 1;
                $checkExistingDataUser->email_verified_at = Carbon::now();
                $checkExistingDataUser->save();

                $checkToken->status = 1;
                $checkToken->save();

                $status = true;
                $response_code = "RC200";
                $message = "Anda Berhasil Verifikasi Akun, silahkan login !!";
                $dataAPI = null;
        
                return $this->onResult($status, $response_code, $message, $dataAPI);
            } catch (\Throwable $error) {
                Log::critical($error);
        
                $response_code = "RC400";
                $message = "Gagal Update Data Kedalam Sistem !!";
                return $this->onResult($status, $response_code, $message, $dataAPI);
            }
        }else {
            $response_code = "RC400";
            $message = "Apakah Anda Robot Ingin Masuk Kedalam Sistem..!!";
            return $this->onResult($status, $response_code, $message, $dataAPI);
        }
    }

    /**
     * Logout user
     * 
     * @return \Illuminate\Routing\Redirector
     */
    public function logoutAuthentication(Request $request)
    {
        Log::critical('logout Aplikasi '.env('APP_NAME').' username : '.Auth::user()->username.' url : '.url('/').' ip : '.request()->server('SERVER_ADDR'). ' akses : '.request()->ip());

        Session::flush();
        Auth::logout();        

        return redirect('/');
    }

    /**
     * Handle response after user authenticated
     * 
     * @param Request $request
     * @param Auth $user
     * @return \Illuminate\Http\Response
     */
    protected function authenticated(Request $request, $user)
    {
        return redirect()->intended();
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
