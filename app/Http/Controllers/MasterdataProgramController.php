<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Facades\DataTables;
use Maatwebsite\Excel\Facades\Excel;

use Carbon\Carbon;
use App\Rules\ReCaptcha;
use App\Http\Controllers\Helpers\mainController;
use App\Imports\FormatImportRealisasiClass;

// Database
use Illuminate\Support\Facades\DB;
use App\Models\mProgramAccount;
use App\Models\mProgramDepartementCCK;
use App\Models\mProgramBagianCC;
use App\Models\mProgram;

class MasterdataProgramController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function page_indexMasterdataProgram(Request $request)
    {
        $model['route'] = 'Master Data Program Anggaran';

        $model['ms_program_account'] = mProgramAccount::get();
        $model['ms_program_departement_cck'] = mProgramDepartementCCK::get();
        $model['ms_program_bagian_cc'] = mProgramBagianCC::get();

        return view('pages.masterdata-program.v_index', ['model' => $model]);
    }    

    public function get_datatableMasterdataProgram(Request $request)
    {
        $status = false;
        $response_code = 'RC400';
        $message = 'Data Gagal Disimpan Terjadi Gangguan..';
        $dataAPI = null;
        
        if ($request->ajax()) {
            
            $form_filter_program = $request->form_filter_program;
            $form_filter_program_account = $request->form_filter_program_account;
            $form_filter_program_departement = $request->form_filter_program_departement;
            $form_filter_program_bagian = $request->form_filter_program_bagian;
            $form_filter_program_kriteria = $request->form_filter_program_kriteria;
            $form_filter_program_direktorat = $request->form_filter_program_direktorat;
            $form_filter_program_kompartemen = $request->form_filter_program_kompartemen;
            $form_filter_program_priority = $request->form_filter_program_priority;

            $dataMsProgram = mProgram::whereNotNull('uuid')->where('status', 1);

            $msProgram = $dataMsProgram->get();

            $jumlahMsProgram = $msProgram->count();
            $totalMsProgramNominal = $msProgram->sum('nominal');

            // Filter Data
            if($form_filter_program != "")
            {
                $dataMsProgram->where('name', 'like', '%'.$form_filter_program.'%')->orWhere('fund_number',$form_filter_program);
            }

            if($form_filter_program_account != "-")
            {
                $checkExistingDataProgramAccount =  mProgramAccount::where('uuid', $request->form_filter_program_account)->first();
                $dataMsProgram->where('id_program_account', $checkExistingDataProgramAccount->id);
            }

            if($form_filter_program_departement != "-")
            {
                $checkExistingDataProgramDepartement =  mProgramDepartementCCK::where('uuid', $request->form_filter_program_departement)->first();
                $dataMsProgram->where('id_program_departement_cck', $checkExistingDataProgramDepartement->id);
            }

            if($form_filter_program_bagian != "-")
            {
                $checkExistingDataProgramBagian =  mProgramBagianCC::where('uuid', $request->form_filter_program_bagian)->first();
                $dataMsProgram->where('id_program_bagian_cc', $checkExistingDataProgramBagian->id);
            }

            if($form_filter_program_kriteria != "-")
            {
                $dataMsProgram->where('kriteria_pengadaan', $request->form_filter_program_kriteria);
            }

            if($form_filter_program_direktorat != "-")
            {
                $dataMsProgram->where('direktorat', $request->form_filter_program_direktorat);
            }

            if($form_filter_program_kompartemen != "-")
            {
                $dataMsProgram->where('kompartemen', $request->form_filter_program_kompartemen);
            }

            if($form_filter_program_priority != "-")
            {
                $dataMsProgram->where('priority', $request->form_filter_program_priority);
            }

            $data = $dataMsProgram->get();

            $jumlahFilterMsProgram = $data->count();
            $totalFilterMsProgramNominal = $data->sum('nominal');

            $jumlahFilterMsProgramSingleYear = $data->where('kriteria_pengadaan', 'Singleyear')->count();
            $totalFilterMsProgramNominalSingleYear = $data->where('kriteria_pengadaan', 'Singleyear')->sum('nominal');
            $jumlahFilterMsProgramMultiYear = $data->where('kriteria_pengadaan', 'Multiyears 24-25')->count();
            $totalFilterMsProgramNominalMultiYear = $data->where('kriteria_pengadaan', 'Multiyears 24-25')->sum('nominal');

            return DataTables::of($data)
            ->with('jumlahMsProgram', number_format($jumlahMsProgram,0,',','.'))
            ->with('totalMsProgramNominal', number_format($totalMsProgramNominal,0,',','.'))
            ->with('jumlahFilterMsProgram', number_format($jumlahFilterMsProgram,0,',','.'))
            ->with('totalFilterMsProgramNominal', number_format($totalFilterMsProgramNominal,0,',','.'))
            ->with('jumlahFilterMsProgramSingleYear', number_format($jumlahFilterMsProgramSingleYear,0,',','.'))
            ->with('totalFilterMsProgramNominalSingleYear', number_format($totalFilterMsProgramNominalSingleYear,0,',','.'))
            ->with('jumlahFilterMsProgramMultiYear', number_format($jumlahFilterMsProgramMultiYear,0,',','.'))
            ->with('totalFilterMsProgramNominalMultiYear', number_format($totalFilterMsProgramNominalMultiYear,0,',','.'))
            ->addIndexColumn()
            ->addColumn('fund_number', function($row)
            {
                $html = '
                <!--begin::User details-->
                <div class="d-flex flex-column text-center">
                    <a href="#" class="text-gray-800 text-hover-primary mb-1 fw-bold">'.$row->fund_number.'</a>
                </div>
                <!--begin::User details-->
                ';

                return $html;
            })
            ->addColumn('fild_name', function($row)
            {
                $html = '
                <!--begin::User details-->
                <div class="d-flex flex-column">
                    <a href="#" class="text-gray-800 text-hover-primary mb-1 fw-bolder fs-5">'.$row->name.'</a>
                    <small>'.$row->code.'</small>
                    <hr>
                </div>
                <!--begin::User details-->
                ';

                return $html;
            })
            ->addColumn('fild_kriteria', function($row)
            {
                $html = '
                <!--begin::User details-->
                <div class="d-flex flex-column">
                    <a href="#" class="text-gray-800 text-hover-primary mb-1 fw-bolder fs-5">'.$row->kriteria_pengadaan.'</a>
                    <small>'.$row->kriteria_program.'</small>
                    <hr>
                </div>
                <!--begin::User details-->
                ';

                return $html;
            })
            ->addColumn('fild_departement', function($row)
            {
                $html = '
                <!--begin::User details-->
                <div class="d-flex flex-column">
                    <a href="#" class="text-gray-800 text-hover-primary mb-1 fw-bolder fs-5">'.$row->name_program_departement_cck.'</a>
                    <small>'.$row->name_program_bagian_cc.'</small>
                    <hr>
                </div>
                <!--begin::User details-->
                ';

                return $html;
            })
            ->addColumn('fild_direktorat', function($row)
            {
                $html = '
                <!--begin::User details-->
                <div class="d-flex flex-column">
                    <a href="#" class="text-gray-800 text-hover-primary mb-1 fw-bolder fs-5">'.$row->direktorat.'</a>
                    <small>'.$row->kompartemen.'</small>
                    <hr>
                </div>
                <!--begin::User details-->
                ';

                return $html;
            })
            ->addColumn('fild_account', function($row)
            {
                $html = '
                <!--begin::User details-->
                <div class="d-flex flex-column text-start">
                    <a href="#" class="text-gray-800 text-hover-primary mb-1 fw-bold">'.$row->name_program_account.'</a>
                </div>
                <!--begin::User details-->
                ';

                return $html;
            })
            ->addColumn('fild_priority', function($row)
            {
                $html = '
                <!--begin::User details-->
                <div class="d-flex flex-column text-start">
                    <a href="#" class="text-gray-800 text-hover-primary mb-1 fw-bold">'.strtoupper($row->priority).'</a>
                </div>
                <!--begin::User details-->
                ';

                return $html;
            })
            ->addColumn('fild_nominal', function($row)
            {
                $html = '
                <!--begin::User details-->
                <div class="d-flex flex-column text-end">
                    <a href="#" class="text-gray-800 text-hover-primary mb-1 fw-bold">'.number_format($row->nominal,0,',','.').'</a>
                </div>
                <!--begin::User details-->
                ';

                return $html;
            })
            ->addColumn('action', function($row)
            {
                if($row->status == 1)
                {
                    $dataStaus = 'nonaktif';
                }else{
                    $dataStaus = 'aktivasi';
                }

                // $html = '<div class="dropdown">
                //     <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                //     Action
                //     </button>
                //     <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                //         <li><a class="dropdown-item" href="#" data-id="'.$row->uuid.'" onclick="act_btnDetailData(this)">Detail Data</a></li>
                //         <li><a class="dropdown-item" href="#" data-id="'.$row->uuid.'" onclick="act_btnUpdateData(this)">Update Data</a></li>
                //         <li><a class="dropdown-item" href="#" data-id="'.$row->uuid.'" data-status="'.$dataStaus.'" onclick="act_UpdateStatusData(this)">Change Status</a></li>
                //     </ul>
                // </div>
                // ';

                $html = '<div class="dropdown">
                    <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                    Action
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                        <li><a class="dropdown-item" href="#" data-id="'.$row->uuid.'" onclick="act_btnUpdateData(this)">Update Data</a></li>
                    </ul>
                </div>
                ';

                return $html;
            })
            ->rawColumns(['fund_number', 'fild_name', 'fild_kriteria', 'fild_departement', 'fild_direktorat', 'fild_account', 'fild_priority', 'fild_nominal', 'action'])
            ->make(true);
        }
        return $this->onResult($status, $response_code, $message, $dataAPI);
    }

    public function act_tambahMasterdataProgram(Request $request)
    {
        $status = false;
        $response_code = 'RC400';
        $message = 'Data Gagal Disimpan Terjadi Gangguan..';
        $dataAPI = null;

        if ($request->ajax()) {  
            // dd($request->all());          
            $validator = Validator::make($request->all(), [
                'form_masterdata_program_fundnumber' => 'required',
                'form_masterdata_program_nama' => 'required',
                'form_masterdata_program_anggaran' => 'required',
            ]);

            // Ketika data kiriman tidak sesuai
            if ($validator->fails())
            {
                $response_code = "RC400";
                $message = "Form Tidak Tervalidasi Dengan Sistem";
                return $this->onResult($status, $response_code, $message, $dataAPI);
            }

            // Cek Data Dalam Database
            $checkExistingDataProgramAccount =  mProgramAccount::where('uuid', $request->form_masterdata_program_account)->first();
            if(!$checkExistingDataProgramAccount)
            {
                $response_code = "RC400";
                $message = "GL Account Program Tidak Terdaftar Dalam Database";
                return $this->onResult($status, $response_code, $message, $dataAPI);
            }

            $checkExistingDataProgramDepartemen =  mProgramDepartementCCK::where('uuid', $request->form_masterdata_program_departement)->first();
            if(!$checkExistingDataProgramDepartemen)
            {
                $response_code = "RC400";
                $message = "Departement Program Tidak Terdaftar Dalam Database";
                return $this->onResult($status, $response_code, $message, $dataAPI);
            }

            $checkExistingDataProgramBagian =  mProgramBagianCC::where('uuid', $request->form_masterdata_program_bagian)->first();
            if(!$checkExistingDataProgramBagian)
            {
                $response_code = "RC400";
                $message = "Bagian Program Tidak Terdaftar Dalam Database";
                return $this->onResult($status, $response_code, $message, $dataAPI);
            }            

            $permitted_chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $nomor_registrasi = "PROGRAM-".random_int(10, 99).date('m').date('d')."-".substr(str_shuffle($permitted_chars), 0, 4)."-".time();

            // Validasi Ketika Gagal Melakukan Transaksi Data Akan Di Rollback
            DB::beginTransaction();

            try {
                // Proses Simpan Data Kedalam Database      
                $AddMasterProgram = new mProgram();

                $AddMasterProgram->uuid =  (string) Str::uuid();
                $AddMasterProgram->code =  $nomor_registrasi;
                $AddMasterProgram->fund_number = $request->form_masterdata_program_fundnumber;
                $AddMasterProgram->cost_center = $request->form_masterdata_program_costcenter;
                $AddMasterProgram->id_program_account =  $checkExistingDataProgramAccount->id;
                $AddMasterProgram->name_program_account =  $checkExistingDataProgramAccount->name;
                $AddMasterProgram->id_program_departement_cck =  $checkExistingDataProgramDepartemen->id;
                $AddMasterProgram->name_program_departement_cck =  $checkExistingDataProgramDepartemen->name;
                $AddMasterProgram->id_program_bagian_cc =  $checkExistingDataProgramBagian->id;
                $AddMasterProgram->name_program_bagian_cc =  $checkExistingDataProgramBagian->name;
                $AddMasterProgram->direktorat = $request->form_masterdata_program_direktorat;
                $AddMasterProgram->kompartemen = $request->form_masterdata_program_kompartemen;
                $AddMasterProgram->name = $request->form_masterdata_program_nama;
                $AddMasterProgram->description = $request->form_masterdata_program_deskripsi;
                $AddMasterProgram->priority = $request->form_masterdata_program_priority;
                $AddMasterProgram->year = date('Y');
                $AddMasterProgram->nominal = $request->form_masterdata_program_anggaran;
                $AddMasterProgram->kriteria_program = 'Original 2024';
                $AddMasterProgram->kriteria_pengadaan = $request->form_masterdata_program_kriteria;
                $AddMasterProgram->status =  1;
                $AddMasterProgram->created_at = Carbon::now();
                $AddMasterProgram->updated_at = Carbon::now();
                $AddMasterProgram->created_by = Auth::user()->id;

                $AddMasterProgram->save();

                DB::commit();

                $status = true;
                $response_code = "RC200";
                $message = "Anda Berhasil Register Program Anggaran !!";

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

    public function act_uploadMasterdataProgram(Request $request)
    {
        $status = false;
        $response_code = 'RC400';
        $message = 'Data Gagal Disimpan Terjadi Gangguan..';
        $dataAPI = null;

        if ($request->ajax()) {  
            // dd($request->all());          
            $validator = Validator::make($request->all(), [
                'form_masterdata_program_upload_tanggal' => 'required'
            ]);

            // Ketika data kiriman tidak sesuai
            if ($validator->fails())
            {
                $response_code = "RC400";
                $message = "Form Tidak Tervalidasi Dengan Sistem";
                return $this->onResult($status, $response_code, $message, $dataAPI);
            }

            // Validasi File Upload
            if(!isset($request->form_masterdata_program_upload_file))
            {
                $response_code = "RC400";
                $message = "Tidak Ada File Excell Yang Di Upload";
                return $this->onResult($status, $response_code, $message, $dataAPI);
            }

            $data_file = null;
            $arrExtension = ['xls','xlt','xlsx','xlsm', 'xlsb', 'xltx', 'xltm'];
            foreach ($request->form_masterdata_program_upload_file as $file) {
                $filesistem_extension = $file->extension();               
                if (!in_array($filesistem_extension, $arrExtension))
                {
                    $response_code = "RC400";
                    $message = "Type File Tidak Sesuai Dengan Sistem ...";
                    return $this->onResult($status, $response_code, $message, $dataAPI);
                }

                $filesistem_size = $file->getSize();
                if($filesistem_size > 2258582)
                {
                    $response_code = "RC400";
                    $message = "Ukuran File  Tidak Sesuai Dengan Sistem ...";
                    return $this->onResult($status, $response_code, $message, $dataAPI);
                }

                $filename = 'data-master-program-'.$request->form_masterdata_program_upload_tanggal."-".time();
                $filename_extension = $filename.".".$filesistem_extension;
                $filesistem = Storage::disk('public')->putFileAs('dokumen-upload/master-program', $file, $filename_extension);
                $data_file = $filename_extension;
            }

            $data_excell = null;

            try {
                // Proses Collection Data Excell      
                $file_upload_program = 'public/dokumen-upload/master-program/'.$data_file;
            
                $rule = new FormatImportRealisasiClass;

                $data_excell = Excel::toCollection($rule, $file_upload_program, null);                
            } catch (\Throwable $error) {
                DB::rollback();
                Log::critical($error);

                $response_code = "RC400";
                $message = "Sistem Gagal Membaca File Excell !!" .$error;
                return $this->onResult($status, $response_code, $message, $dataAPI);
            }

            $data_sukses = null;
            $data_gagal = null;

            foreach ($data_excell[0] as $index => $row)
            {
                if($index == 0)
                {
                    // format excell harus sesuai
                    // $row[0] = NO
                    // $row[1] = PROGRAM
                    // $row[4] = NILAI EAC (4)
                    // $row[7] = ACCOUNT (7)
                    // $row[12] = GL ACCOUNT
                    // $row[13] = FUND NUMBER

                    if($row[0] != 'NO' && $row[1] != 'PROGRAM' && $row[4] != 'NILAI EAC (4)' && $row[7] != 'ACCOUNT (7)' && $row[12] != 'GL ACCOUNT' && $row[13] != 'FUND NUMBER')
                    {
                        $response_code = "RC400";
                        $message = "File Master Data Excell Tidak Sesuai !!";
                        return $this->onResult($status, $response_code, $message, $dataAPI);
                    }
                }
                
                if ($index >= 1)
                {
                    if ($row[0] != null)
                    {
                        // Cek Data Dalam Database
                        $checkExistingDataProgramAccount =  mProgramAccount::where('code', $row[12])->first();
                        $checkExistingDataProgramDepartemen =  mProgramDepartementCCK::where('name', $row[8])->first();
                        $checkExistingDataProgramBagian =  mProgramBagianCC::where('name', $row[46])->first();

                        $permitted_chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
                        $nomor_registrasi = "PROGRAM-".random_int(10, 99).date('m').date('d')."-".substr(str_shuffle($permitted_chars), 0, 4)."-".time();

                        $array_priority = ["high","medium","low"];
                        $randomIndex = array_rand($array_priority);
                        $rand_priority = $array_priority[$randomIndex];

                        // Validasi Ketika Gagal Melakukan Transaksi Data Akan Di Rollback
                        DB::beginTransaction();

                        try {
                            // Proses Simpan Data Kedalam Database      
                            $AddMasterProgram = new mProgram();

                            $AddMasterProgram->uuid =  (string) Str::uuid();
                            $AddMasterProgram->code =  $nomor_registrasi;
                            $AddMasterProgram->fund_number = $row[13];
                            $AddMasterProgram->cost_center = $row[11];
                            $AddMasterProgram->fund_center = $row[0];
                            $AddMasterProgram->id_program_account = @$checkExistingDataProgramAccount->id;
                            $AddMasterProgram->name_program_account = @$checkExistingDataProgramAccount->name;
                            $AddMasterProgram->id_program_departement_cck =  @$checkExistingDataProgramDepartemen->id;
                            $AddMasterProgram->name_program_departement_cck =  @$checkExistingDataProgramDepartemen->name;
                            $AddMasterProgram->id_program_bagian_cc =  @$checkExistingDataProgramBagian->id;
                            $AddMasterProgram->name_program_bagian_cc =  @$checkExistingDataProgramBagian->name;
                            $AddMasterProgram->direktorat = $row[9];
                            $AddMasterProgram->kompartemen = $row[10];
                            $AddMasterProgram->name = $row[1];
                            $AddMasterProgram->description = $row[1];
                            $AddMasterProgram->priority = $rand_priority;
                            $AddMasterProgram->year = date('Y');
                            
                            $nominal = 0;
                            // if(strstr($row[4], '.'))
                            // {
                            //     $tmp_nominal = preg_replace(".", "", $row[4]);
                            //     $nominal = $tmp_nominal."00000";
                            // }else{
                            //     $nominal = $row[4]."000000";
                            // }
                            if($row[4])
                            {
                                $nominal = $row[4] * 1000000;
                            }
                            $AddMasterProgram->nominal = $nominal;

                            $AddMasterProgram->kriteria_program = $row[6];
                            $AddMasterProgram->kriteria_pengadaan = $row[39];
                            $AddMasterProgram->type_pengadaan = $row[16];
                            $AddMasterProgram->lokasi_pengadaan = $row[18];
                            $AddMasterProgram->status =  1;
                            $AddMasterProgram->created_at = Carbon::now();
                            $AddMasterProgram->updated_at = Carbon::now();
                            $AddMasterProgram->created_by = Auth::user()->id;

                            $AddMasterProgram->save();

                            DB::commit();               
                        } catch (\Throwable $error) {
                            DB::rollback();
                            Log::critical($error);
                        }
                    }                    
                }                
            }            

            $status = true;
            $response_code = 'RC200';
            $message = 'Data Berhasil Di Simpan, Terimakasih';           

            return $this->onResult($status, $response_code, $message, $dataAPI); 

        }
        return $this->onResult($status, $response_code, $message, $dataAPI);
    }

    public function act_detailMasterdataProgram(Request $request)
    {
        $status = false;
        $response_code = 'RC400';
        $message = 'Data Gagal Disimpan Terjadi Gangguan..';
        $dataAPI = null;

        if ($request->ajax()) {
            // dd($request->all());
            // sleep(2);
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

            // Cek Data Dalam Database
            $checkExistingData =  mProgram::with('mProgramAccount', 'mProgramDepartementCCK', 'mProgramBagianCC', 'trProgresProgramSR')->where('uuid', $request->data_id)->first();

            if(!$checkExistingData)
            {
                $response_code = "RC400";
                $message = "Data Tidak Ada Dalam Sistem";
                return $this->onResult($status, $response_code, $message, $dataAPI);
            }

            $dataAPI = $checkExistingData;
            $status = true;
            $response_code = "RC200";
            $message = "Anda Berhasil Load Data !!";
        }
        return $this->onResult($status, $response_code, $message, $dataAPI);
    }

    public function act_updateMasterdataProgram(Request $request)
    {
        $status = false;
        $response_code = 'RC400';
        $message = 'Data Gagal Disimpan Terjadi Gangguan..';
        $dataAPI = null;

        if ($request->ajax()) {  
            // dd($request->all());          
            $validator = Validator::make($request->all(), [
                'form_masterdata_program_uuid' => 'required',
                'form_masterdata_program_fundnumber' => 'required',
                'form_masterdata_program_nama' => 'required',
                'form_masterdata_program_anggaran' => 'required',
            ]);

            // Ketika data kiriman tidak sesuai
            if ($validator->fails())
            {
                $response_code = "RC400";
                $message = "Form Tidak Tervalidasi Dengan Sistem";
                return $this->onResult($status, $response_code, $message, $dataAPI);
            }

            // Cek Data Dalam Database
            $checkExistingData =  mProgram::with('mProgramAccount', 'mProgramDepartementCCK', 'mProgramBagianCC')->where('uuid', $request->form_masterdata_program_uuid)->first();

            if(!$checkExistingData)
            {
                $response_code = "RC400";
                $message = "Data Tidak Ada Dalam Sistem";
                return $this->onResult($status, $response_code, $message, $dataAPI);
            }

            // Cek Data Dalam Database
            $checkExistingDataProgramAccount =  mProgramAccount::where('uuid', $request->form_masterdata_program_account)->first();
            if(!$checkExistingDataProgramAccount)
            {
                $response_code = "RC400";
                $message = "GL Account Program Tidak Terdaftar Dalam Database";
                return $this->onResult($status, $response_code, $message, $dataAPI);
            }

            $checkExistingDataProgramDepartemen =  mProgramDepartementCCK::where('uuid', $request->form_masterdata_program_departement)->first();
            if(!$checkExistingDataProgramDepartemen)
            {
                $response_code = "RC400";
                $message = "Departement Program Tidak Terdaftar Dalam Database";
                return $this->onResult($status, $response_code, $message, $dataAPI);
            }

            $checkExistingDataProgramBagian =  mProgramBagianCC::where('uuid', $request->form_masterdata_program_bagian)->first();
            if(!$checkExistingDataProgramBagian)
            {
                $response_code = "RC400";
                $message = "Bagian Program Tidak Terdaftar Dalam Database";
                return $this->onResult($status, $response_code, $message, $dataAPI);
            }

            // Validasi Ketika Gagal Melakukan Transaksi Data Akan Di Rollback
            DB::beginTransaction();

            try {
                // Proses Simpan Data Kedalam Database      
                $checkExistingData->fund_number = $request->form_masterdata_program_fundnumber;
                $checkExistingData->cost_center = $request->form_masterdata_program_costcenter;
                $checkExistingData->id_program_account =  $checkExistingDataProgramAccount->id;
                $checkExistingData->name_program_account =  $checkExistingDataProgramAccount->name;
                $checkExistingData->id_program_departement_cck =  $checkExistingDataProgramDepartemen->id;
                $checkExistingData->name_program_departement_cck =  $checkExistingDataProgramDepartemen->name;
                $checkExistingData->id_program_bagian_cc =  $checkExistingDataProgramBagian->id;
                $checkExistingData->name_program_bagian_cc =  $checkExistingDataProgramBagian->name;
                $checkExistingData->direktorat = $request->form_masterdata_program_direktorat;
                $checkExistingData->kompartemen = $request->form_masterdata_program_kompartemen;
                $checkExistingData->name = $request->form_masterdata_program_nama;
                $checkExistingData->description = $request->form_masterdata_program_deskripsi;
                $checkExistingData->priority = $request->form_masterdata_program_priority;
                $checkExistingData->year = date('Y');
                $checkExistingData->nominal = $request->form_masterdata_program_anggaran;
                $checkExistingData->kriteria_program = 'Original 2024';
                $checkExistingData->kriteria_pengadaan = $request->form_masterdata_program_kriteria;
                $checkExistingData->updated_at = Carbon::now();
                $checkExistingData->updated_by = Auth::user()->id;

                $checkExistingData->save();

                DB::commit();

                $status = true;
                $response_code = "RC200";
                $message = "Anda Berhasil Update Program Anggaran !!";

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

    private static function onResult($status, $response_code, $message, $data)
    {
        $model['status'] = $status;
        $model['response_code'] = $response_code;
        $model['message'] = $message;
        $model['data'] = $data;
        return response()->json($model, 200);
    }
}
