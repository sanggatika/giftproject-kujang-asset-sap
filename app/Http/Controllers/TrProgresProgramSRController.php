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
use App\Models\trProgresProgramSR;
use App\Models\trProgramRealisasi;

class TrProgresProgramSRController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function page_indexTrProgresProgramSR(Request $request)
    {
        $model['route'] = 'Master Data Program Anggaran';

        $model['ms_program_jenis_cck'] = mProgramJenisCCK::get();
        $model['ms_program_lokasi_cc'] = mProgramLokasiCC::get();

        return view('pages.transaksi-progres-program-sr.v_index', ['model' => $model]);
    } 
    
    public function get_datatableTrProgresProgramSR(Request $request)
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

            $form_filter_program_sr_nomor = $request->form_filter_program_sr_nomor;
            $form_filter_program_status = $request->form_filter_program_status;
            $form_filter_program_min_anggaran = $request->form_filter_program_min_anggaran;
            $form_filter_program_max_anggaran = $request->form_filter_program_max_anggaran;

            $dataMsProgram = mProgram::with('trProgresProgramSR')->whereNotNull('uuid');

            $msProgram = $dataMsProgram->get();
            $jumlahMsProgram = $msProgram->count();
            $totalMsProgramNominal = $msProgram->sum('nominal');

            // Filter Data
            if($form_filter_program != "")
            {
                $dataMsProgram->where('name', 'like', '%'.$form_filter_program.'%')->orWhere('fund_number',$form_filter_program);;
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

            if($form_filter_program_sr_nomor != "")
            {
                $data_filter = $form_filter_program_sr_nomor;
                $dataMsProgram->whereHas('trProgresProgramSR', function ($query) use ($data_filter) {
                    $query->where('sr_nomor', $data_filter);
                });
            }

            if($form_filter_program_status != "-")
            {
                if($form_filter_program_status == "sudah update")
                {
                    $dataMsProgram->has('trProgresProgramSR');
                }

                if($form_filter_program_status == "belum update")
                {
                    $dataMsProgram->doesntHave('trProgresProgramSR');
                }
            }

            if($form_filter_program_min_anggaran != "")
            {
                $minAnggaran = intval($form_filter_program_min_anggaran);
                $dataMsProgram->where('nominal', '>=', $minAnggaran);
            }

            if($form_filter_program_max_anggaran != "")
            {
                $maxAnggaran = intval($form_filter_program_max_anggaran);
                $dataMsProgram->where('nominal', '<=', $maxAnggaran);
            }

            $data = $dataMsProgram->get();

            $jumlahFilterMsProgram = $data->count();
            $totalFilterMsProgramNominal = $data->sum('nominal');

            $jumlahFilterMsProgramSR = trProgresProgramSR::count();
            $totalFilterMsProgramNominalSR = trProgresProgramSR::sum('nominal');

            $jumlahFilterMsProgramSRBelum = $jumlahMsProgram - $jumlahFilterMsProgramSR;
            $totalFilterMsProgramNominalSRBelum = $totalMsProgramNominal - $totalFilterMsProgramNominalSR;

            return DataTables::of($data)
            ->with('jumlahMsProgram', number_format($jumlahMsProgram,0,',','.'))
            ->with('totalMsProgramNominal', number_format($totalMsProgramNominal,0,',','.'))
            ->with('jumlahFilterMsProgram', number_format($jumlahFilterMsProgram,0,',','.'))
            ->with('totalFilterMsProgramNominal', number_format($totalFilterMsProgramNominal,0,',','.'))
            ->with('jumlahFilterMsProgramSR', number_format($jumlahFilterMsProgramSR,0,',','.'))
            ->with('totalFilterMsProgramNominalSR', number_format($totalFilterMsProgramNominalSR,0,',','.'))
            ->with('jumlahFilterMsProgramSRBelum', number_format($jumlahFilterMsProgramSRBelum,0,',','.'))
            ->with('totalFilterMsProgramNominalSRBelum', number_format($totalFilterMsProgramNominalSRBelum,0,',','.'))
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
                    <a href="#" class="text-gray-800 text-hover-primary mb-1 fw-bold">'.$row->name_program_jenis_cck.' - '.$row->name_program_lokasi_cc.' - '.strtoupper($row->priority).'</a>
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
            ->addColumn('fild_tanggal', function($row)
            {
                $tanggal = "-";
                if($row->trProgresProgramSR)
                {
                    $tanggal = Carbon::parse($row->trProgresProgramSR->sr_tanggal)->format('d F Y');
                }
                $html = '
                <!--begin::User details-->
                <div class="d-flex flex-column text-start">
                    <a href="#" class="text-gray-800 text-hover-primary mb-1 fw-bold"> '.$tanggal.' </a>
                </div>
                <!--begin::User details-->
                ';

                return $html;
            })
            ->addColumn('fild_nomor', function($row)
            {
                $nomor = "-";
                if($row->trProgresProgramSR)
                {
                    $nomor = $row->trProgresProgramSR->sr_nomor;
                }
                $html = '
                <!--begin::User details-->
                <div class="d-flex flex-column text-start">
                    <a href="#" class="text-gray-800 text-hover-primary mb-1 fw-bold">'.$nomor.'</a>
                </div>
                <!--begin::User details-->
                ';

                return $html;
            })
            ->addColumn('fild_nominal_fix', function($row)
            {
                $nominal_fix = "-";
                if($row->trProgresProgramSR)
                {
                    $nominal_fix = number_format($row->trProgresProgramSR->sr_nominal,0,',','.');
                }
                $html = '
                <!--begin::User details-->
                <div class="d-flex flex-column text-end">
                    <a href="#" class="text-gray-800 text-hover-primary mb-1 fw-bold">'.$nominal_fix.'</a>
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

                $html = '<div class="dropdown">
                    <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                    Action
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                        <li><a class="dropdown-item" href="#" data-id="'.$row->uuid.'" onclick="act_btnUpdateData(this)">Update Data</a></li>
                        <li><a class="dropdown-item" href="#" data-id="'.$row->uuid.'" onclick="act_btnPurchaseRequisition(this)">Purchase Requisition (PR)</a></li>
                    </ul>
                </div>
                ';

                return $html;
            })
            ->rawColumns(['fund_number', 'fild_name', 'fild_nominal', 'fild_tanggal', 'fild_nomor', 'fild_nominal_fix', 'action'])
            ->make(true);
        }
        return $this->onResult($status, $response_code, $message, $dataAPI);
    }

    public function act_detailTrProgresProgramSR(Request $request)
    {
        $status = false;
        $response_code = 'RC400';
        $message = 'Data Gagal Disimpan Terjadi Gangguan..';
        $dataAPI = null;

        if ($request->ajax()) {
            // dd($request->all());
            // sleep(2);
            $validator = Validator::make($request->all(), [
                'form_masterdata_program_fundnumber' => 'required',
            ]);

            // Ketika data kiriman tidak sesuai
            if ($validator->fails())
            {
                $response_code = "RC400";
                $message = "Form Tidak Tervalidasi Dengan Sistem";
                return $this->onResult($status, $response_code, $message, $dataAPI);
            }

            // Cek Data Dalam Database
            $checkExistingData =  trProgresProgramSR::with('mProgramJenisCCK', 'mProgramLokasiCC')->where('fund_number', $request->form_masterdata_program_fundnumber)->orWhere('sr_nomor', $request->form_masterdata_program_fundnumber)->first();

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

    public function act_updateTrProgresProgramSR(Request $request)
    {
        $status = false;
        $response_code = 'RC400';
        $message = 'Data Gagal Disimpan Terjadi Gangguan..';
        $dataAPI = null;

        if ($request->ajax()) {  
            // dd($request->all());          
            $validator = Validator::make($request->all(), [
                'form_masterdata_program_uuid' => 'required',
                'form_masterdata_program_tanggal' => 'required',
                'form_masterdata_program_nomor_mmr' => 'required',
                'form_masterdata_program_anggaran_fix' => 'required',
            ]);

            // Ketika data kiriman tidak sesuai
            if ($validator->fails())
            {
                $response_code = "RC400";
                $message = "Form Tidak Tervalidasi Dengan Sistem";
                return $this->onResult($status, $response_code, $message, $dataAPI);
            }

            // Cek Data Dalam Database
            $checkExistingDataProgram =  mProgram::with('mProgramJenisCCK', 'mProgramLokasiCC')->where('uuid', $request->form_masterdata_program_uuid)->first();

            if(!$checkExistingDataProgram)
            {
                $response_code = "RC400";
                $message = "Data Tidak Ada Dalam Sistem";
                return $this->onResult($status, $response_code, $message, $dataAPI);
            }

            // Validasi Ketika Gagal Melakukan Transaksi Data Akan Di Rollback
            DB::beginTransaction();
            try {
                $checkExistingTrProgramProgresSR =  trProgresProgramSR::where('id_program', $checkExistingDataProgram->id)->first();

                if($checkExistingTrProgramProgresSR)
                {   
                    $checkExistingTrProgramProgresSR->sr_tanggal = $request->form_masterdata_program_tanggal;
                    $checkExistingTrProgramProgresSR->sr_nominal = $request->form_masterdata_program_anggaran_fix;
                    $checkExistingTrProgramProgresSR->sr_nomor = $request->form_masterdata_program_nomor_mmr;
                    $checkExistingTrProgramProgresSR->updated_at = Carbon::now();
                    $checkExistingTrProgramProgresSR->updated_by = Auth::user()->id;

                    $checkExistingTrProgramProgresSR->save();
                }else{
                    $permitted_chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
                    $nomor_registrasi = "TRPROGSR-".random_int(10, 99).date('m').date('d')."-".substr(str_shuffle($permitted_chars), 0, 4)."-".time();

                    // Proses Simpan Data Kedalam Database      
                    $AddTrProgramProgresSR = new trProgresProgramSR();

                    $AddTrProgramProgresSR->uuid =  (string) Str::uuid();
                    $AddTrProgramProgresSR->code =  $nomor_registrasi;
                    $AddTrProgramProgresSR->id_program =  $checkExistingDataProgram->id;
                    $AddTrProgramProgresSR->fund_number = $checkExistingDataProgram->fund_number;
                    $AddTrProgramProgresSR->id_program_jenis_cck =  $checkExistingDataProgram->id_program_jenis_cck;
                    $AddTrProgramProgresSR->name_program_jenis_cck =  $checkExistingDataProgram->name_program_jenis_cck;
                    $AddTrProgramProgresSR->fund_center = $checkExistingDataProgram->fund_center;
                    $AddTrProgramProgresSR->id_program_lokasi_cc =  $checkExistingDataProgram->id_program_lokasi_cc;
                    $AddTrProgramProgresSR->name_program_lokasi_cc =  $checkExistingDataProgram->name_program_lokasi_cc;
                    $AddTrProgramProgresSR->name = $checkExistingDataProgram->name;
                    $AddTrProgramProgresSR->description = $checkExistingDataProgram->description;
                    $AddTrProgramProgresSR->priority = $checkExistingDataProgram->priority;
                    $AddTrProgramProgresSR->year = $checkExistingDataProgram->year;
                    $AddTrProgramProgresSR->nominal = $checkExistingDataProgram->nominal;
                    $AddTrProgramProgresSR->sr_tanggal = $request->form_masterdata_program_tanggal;
                    $AddTrProgramProgresSR->sr_nominal = $request->form_masterdata_program_anggaran_fix;
                    $AddTrProgramProgresSR->sr_nomor = $request->form_masterdata_program_nomor_mmr;
                    $AddTrProgramProgresSR->status =  1;
                    $AddTrProgramProgresSR->created_at = Carbon::now();
                    $AddTrProgramProgresSR->updated_at = Carbon::now();
                    $AddTrProgramProgresSR->created_by = Auth::user()->id;

                    $AddTrProgramProgresSR->save();
                }

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
