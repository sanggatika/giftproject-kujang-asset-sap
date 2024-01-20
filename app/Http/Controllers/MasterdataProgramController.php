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

use Carbon\Carbon;
use App\Rules\ReCaptcha;
use App\Http\Controllers\Helpers\mainController;

// Database
use Illuminate\Support\Facades\DB;
use App\Models\mProgramJenisCCK;
use App\Models\mProgramLokasiCC;
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

        $model['ms_program_jenis_cck'] = mProgramJenisCCK::get();
        $model['ms_program_lokasi_cc'] = mProgramLokasiCC::get();

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
            $form_filter_program_jenis = $request->form_filter_program_jenis;
            $form_filter_program_lokasi = $request->form_filter_program_lokasi;
            $form_filter_program_priority = $request->form_filter_program_priority;

            $dataMsProgram = mProgram::whereNotNull('uuid');

            $msProgram = $dataMsProgram->get();
            $jumlahMsProgram = $msProgram->count();
            $totalMsProgramNominal = $msProgram->sum('nominal');
            $jumlahMsProgramJenis = $msProgram->groupBy('id_program_jenis_cck')->count();
            $jumlahMsProgramLokasi = $msProgram->groupBy('id_program_lokasi_cc')->count();

            // Filter Data
            if($form_filter_program != "")
            {
                $dataMsProgram->where('name', 'like', '%'.$form_filter_program.'%');
            }

            if($form_filter_program_jenis != "-")
            {
                $checkExistingDataProgramJenis =  mProgramJenisCCK::where('uuid', $request->form_filter_program_jenis)->first();
                $dataMsProgram->where('id_program_jenis_cck', $checkExistingDataProgramJenis->id);
            }

            if($form_filter_program_lokasi != "-")
            {
                $checkExistingDataProgramLokasi =  mProgramLokasiCC::where('uuid', $request->form_filter_program_lokasi)->first();
                $dataMsProgram->where('id_program_lokasi_cc', $checkExistingDataProgramLokasi->id);
            }

            if($form_filter_program_priority != "-")
            {
                $dataMsProgram->where('priority', $request->form_filter_program_priority);
            }

            $data = $dataMsProgram->get();

            $jumlahFilterMsProgram = $data->count();
            $totalFilterMsProgramNominal = $data->sum('nominal');

            return DataTables::of($data)
            ->with('jumlahMsProgram', number_format($jumlahMsProgram,0,',','.'))
            ->with('totalMsProgramNominal', number_format($totalMsProgramNominal,0,',','.'))
            ->with('jumlahMsProgramJenis', number_format($jumlahMsProgramJenis,0,',','.'))
            ->with('jumlahMsProgramLokasi', number_format($jumlahMsProgramLokasi,0,',','.'))
            ->with('jumlahMsProgram', number_format($jumlahMsProgram,0,',','.'))
            ->with('jumlahFilterMsProgram', number_format($jumlahFilterMsProgram,0,',','.'))
            ->with('totalFilterMsProgramNominal', number_format($totalFilterMsProgramNominal,0,',','.'))
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
            ->addColumn('fild_jenis', function($row)
            {
                $html = '
                <!--begin::User details-->
                <div class="d-flex flex-column">
                    <a href="#" class="text-gray-800 text-hover-primary mb-1 fw-bolder fs-5">'.$row->name_program_jenis_cck.'</a>
                    <small>'.$row->fund_center.'</small>
                    <hr>
                </div>
                <!--begin::User details-->
                ';

                return $html;
            })
            ->addColumn('fild_lokasi', function($row)
            {
                $html = '
                <!--begin::User details-->
                <div class="d-flex flex-column text-start">
                    <a href="#" class="text-gray-800 text-hover-primary mb-1 fw-bold">'.$row->name_program_lokasi_cc.'</a>
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
            ->rawColumns(['fund_number', 'fild_name', 'fild_jenis', 'fild_lokasi', 'fild_priority', 'fild_nominal', 'action'])
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
                'form_masterdata_program_nama' => 'required',
                'form_masterdata_program_deskripsi' => 'required',
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
            $checkExistingDataProgramJenis =  mProgramJenisCCK::where('uuid', $request->form_masterdata_program_jenis)->first();

            if(!$checkExistingDataProgramJenis)
            {
                $response_code = "RC400";
                $message = "Jenis Program Tidak Terdaftar Dalam Database";
                return $this->onResult($status, $response_code, $message, $dataAPI);
            }

            $checkExistingDataProgramLokasi =  mProgramLokasiCC::where('uuid', $request->form_masterdata_program_lokasi)->first();

            if(!$checkExistingDataProgramLokasi)
            {
                $response_code = "RC400";
                $message = "Lokasi Program Tidak Terdaftar Dalam Database";
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
                $AddMasterProgram->id_program_jenis_cck =  $checkExistingDataProgramJenis->id;
                $AddMasterProgram->name_program_jenis_cck =  $checkExistingDataProgramJenis->name;
                $AddMasterProgram->fund_center = $request->form_masterdata_program_fundcenter;
                $AddMasterProgram->id_program_lokasi_cc =  $checkExistingDataProgramLokasi->id;
                $AddMasterProgram->name_program_lokasi_cc =  $checkExistingDataProgramLokasi->name;
                $AddMasterProgram->name = $request->form_masterdata_program_nama;
                $AddMasterProgram->description = $request->form_masterdata_program_deskripsi;
                $AddMasterProgram->priority = $request->form_masterdata_program_priority;
                $AddMasterProgram->year = date('Y');
                $AddMasterProgram->nominal = $request->form_masterdata_program_anggaran;
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
            $checkExistingData =  mProgram::with('mProgramJenisCCK', 'mProgramLokasiCC')->where('uuid', $request->data_id)->first();

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
                'form_masterdata_program_nama' => 'required',
                'form_masterdata_program_deskripsi' => 'required',
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
            $checkExistingData =  mProgram::with('mProgramJenisCCK', 'mProgramLokasiCC')->where('uuid', $request->form_masterdata_program_uuid)->first();

            if(!$checkExistingData)
            {
                $response_code = "RC400";
                $message = "Data Tidak Ada Dalam Sistem";
                return $this->onResult($status, $response_code, $message, $dataAPI);
            }

            // Cek Data Dalam Database
            $checkExistingDataProgramJenis =  mProgramJenisCCK::where('uuid', $request->form_masterdata_program_jenis)->first();

            if(!$checkExistingDataProgramJenis)
            {
                $response_code = "RC400";
                $message = "Jenis Program Tidak Terdaftar Dalam Database";
                return $this->onResult($status, $response_code, $message, $dataAPI);
            }

            $checkExistingDataProgramLokasi =  mProgramLokasiCC::where('uuid', $request->form_masterdata_program_lokasi)->first();

            if(!$checkExistingDataProgramLokasi)
            {
                $response_code = "RC400";
                $message = "Lokasi Program Tidak Terdaftar Dalam Database";
                return $this->onResult($status, $response_code, $message, $dataAPI);
            }

            // Validasi Ketika Gagal Melakukan Transaksi Data Akan Di Rollback
            DB::beginTransaction();

            try {
                // Proses Simpan Data Kedalam Database      
                $checkExistingData->fund_number = $request->form_masterdata_program_fundnumber;
                $checkExistingData->id_program_jenis_cck =  $checkExistingDataProgramJenis->id;
                $checkExistingData->name_program_jenis_cck =  $checkExistingDataProgramJenis->name;
                $checkExistingData->fund_center = $request->form_masterdata_program_fundcenter;
                $checkExistingData->id_program_lokasi_cc =  $checkExistingDataProgramLokasi->id;
                $checkExistingData->name_program_lokasi_cc =  $checkExistingDataProgramLokasi->name;
                $checkExistingData->name = $request->form_masterdata_program_nama;
                $checkExistingData->description = $request->form_masterdata_program_deskripsi;
                $checkExistingData->priority = $request->form_masterdata_program_priority;
                $checkExistingData->nominal = $request->form_masterdata_program_anggaran;
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
