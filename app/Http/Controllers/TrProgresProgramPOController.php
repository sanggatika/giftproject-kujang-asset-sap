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
use App\Models\trProgresProgramPR;
use App\Models\trProgresProgramPO;
use App\Models\trProgramRealisasi;

class TrProgresProgramPOController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function page_indexTrProgresProgramPO(Request $request)
    {
        $model['route'] = 'Master Data Program Anggaran';

        $model['ms_program_jenis_cck'] = mProgramJenisCCK::get();
        $model['ms_program_lokasi_cc'] = mProgramLokasiCC::get();

        return view('pages.transaksi-progres-program-po.v_index', ['model' => $model]);
    } 

    public function get_datatableTrProgresProgramPO(Request $request)
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

            $form_filter_program_fundnumber = $request->form_filter_program_fundnumber;
            $form_filter_program_min_anggaran = $request->form_filter_program_min_anggaran;
            $form_filter_program_max_anggaran = $request->form_filter_program_max_anggaran;

            $dataTrProgresProgramPO = trProgresProgramPO::whereNotNull('uuid');

            // Filter Data
            if($form_filter_program != "")
            {
                $dataTrProgresProgramPO->where('name', 'like', '%'.$form_filter_program.'%');
            }

            if($form_filter_program_jenis != "-")
            {
                $checkExistingDataProgramJenis =  mProgramJenisCCK::where('uuid', $request->form_filter_program_jenis)->first();
                $dataTrProgresProgramPO->where('id_program_jenis_cck', $checkExistingDataProgramJenis->id);
            }

            if($form_filter_program_lokasi != "-")
            {
                $checkExistingDataProgramLokasi =  mProgramLokasiCC::where('uuid', $request->form_filter_program_lokasi)->first();
                $dataTrProgresProgramPO->where('id_program_lokasi_cc', $checkExistingDataProgramLokasi->id);
            }

            if($form_filter_program_priority != "-")
            {
                $dataTrProgresProgramPO->where('priority', $request->form_filter_program_priority);
            }

            if($form_filter_program_fundnumber != "")
            {
                $dataTrProgresProgramPO->where('fund_number', 'like', '%'.$form_filter_program_fundnumber.'%');
            }

            if($form_filter_program_min_anggaran != "")
            {
                $minAnggaran = intval($form_filter_program_min_anggaran);
                $dataTrProgresProgramPO->where('nominal', '>=', $minAnggaran);
            }

            if($form_filter_program_max_anggaran != "")
            {
                $maxAnggaran = intval($form_filter_program_max_anggaran);
                $dataTrProgresProgramPO->where('nominal', '<=', $maxAnggaran);
            }

            $data = $dataTrProgresProgramPO->get();

            return DataTables::of($data)
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
                $tanggal = Carbon::parse($row->po_tanggal)->format('d F Y');
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
                $nomor = $row->po_nomor;
                $html = '
                <!--begin::User details-->
                <div class="d-flex flex-column text-start">
                    <a href="#" class="text-gray-800 text-hover-primary mb-1 fw-bold">'.$nomor.'</a>
                </div>
                <!--begin::User details-->
                ';

                return $html;
            })
            ->addColumn('fild_tanggal_estimasi', function($row)
            {
                $tanggal_estimasi = Carbon::parse($row->po_tempo)->format('d F Y');
                $html = '
                <!--begin::User details-->
                <div class="d-flex flex-column text-start">
                    <a href="#" class="text-gray-800 text-hover-primary mb-1 fw-bold"> '.$tanggal_estimasi.' </a>
                </div>
                <!--begin::User details-->
                ';

                return $html;
            })
            ->addColumn('fild_nominal_fix', function($row)
            {
                $nominal_fix = number_format($row->po_nominal,0,',','.');
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
                        <li><a class="dropdown-item" href="#" data-id="'.$row->uuid.'" onclick="act_btnGoodReceipt(this)">Good Receipt (GR)</a></li>
                    </ul>
                </div>
                ';

                return $html;
            })
            ->rawColumns(['fund_number', 'fild_name', 'fild_nominal', 'fild_tanggal', 'fild_nomor', 'fild_tanggal_estimasi', 'fild_nominal_fix', 'action'])
            ->make(true);
        }
        return $this->onResult($status, $response_code, $message, $dataAPI);
    }
    
    public function act_tambahTrProgresProgramPO(Request $request)
    {
        $status = false;
        $response_code = 'RC400';
        $message = 'Data Gagal Disimpan Terjadi Gangguan..';
        $dataAPI = null;

        if ($request->ajax()) {  
            // dd($request->all());          
            $validator = Validator::make($request->all(), [
                'form_masterdata_program_pr_nomor' => 'required',
                'form_masterdata_program_pr_uuid' => 'required',
                'form_masterdata_program_po_tanggal' => 'required',
                'form_masterdata_program_po_nomor' => 'required',
                'form_masterdata_program_po_anggaran' => 'required',
                'form_masterdata_program_po_vendor' => 'required',
                'form_masterdata_program_po_otoritas' => 'required',
                'form_masterdata_program_po_tanggal_estimasi' => 'required',
            ]);

            // Ketika data kiriman tidak sesuai
            if ($validator->fails())
            {
                $response_code = "RC400";
                $message = "Form Tidak Tervalidasi Dengan Sistem";
                return $this->onResult($status, $response_code, $message, $dataAPI);
            }

            // Cek Data Dalam Database
            $checkExistingTrProgresProgramPR =  trProgresProgramPR::with('trProgresProgramPO')->where('uuid', $request->form_masterdata_program_pr_uuid)->first();
            // dd($checkExistingTrProgresProgramSR);

            if(!$checkExistingTrProgresProgramPR)
            {
                $response_code = "RC400";
                $message = "Transaksi Progres Program PR Tidak Ada Dalam Sistem";
                return $this->onResult($status, $response_code, $message, $dataAPI);
            }

            $total_pengajuan_pr = $request->form_masterdata_program_po_anggaran;

            if($checkExistingTrProgresProgramPR->trProgresProgramPO)
            {
                $interval_pengajuan = $checkExistingTrProgresProgramPR->trProgresProgramPO->sum('po_nominal') + intval($request->form_masterdata_program_po_anggaran);
                // dd($interval_pengajuan);
                if($interval_pengajuan > $checkExistingTrProgresProgramPR->pr_nominal)
                {
                    $response_code = "RC400";
                    $message = "Pengajuan Purchase Requisition (PR) Melebihi Anggaran";
                    return $this->onResult($status, $response_code, $message, $dataAPI);
                }

                $total_pengajuan_pr = $interval_pengajuan;
            }
            // dd($total_pengajuan_sr);

            // Cek Data Dalam Database
            $checkExistingTrProgramRealisasi =  trProgramRealisasi::where('id_program', $checkExistingTrProgresProgramPR->id_program)->first();
            if(!$checkExistingTrProgramRealisasi)
            {
                $response_code = "RC400";
                $message = "Realisasi Program Tidak Ada Dalam Database";
                return $this->onResult($status, $response_code, $message, $dataAPI);
            }

            // dd($checkExistingTrProgramRealisasi);

            $permitted_chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $nomor_registrasi = "TRPROGPO-".random_int(10, 99).date('m').date('d')."-".substr(str_shuffle($permitted_chars), 0, 4)."-".time();

            // Validasi Ketika Gagal Melakukan Transaksi Data Akan Di Rollback
            DB::beginTransaction();

            try {    
                // Proses Simpan Data Kedalam Database      
                $AddTrProgramProgresPO = new trProgresProgramPO();

                $AddTrProgramProgresPO->uuid =  (string) Str::uuid();
                $AddTrProgramProgresPO->code =  $nomor_registrasi;
                $AddTrProgramProgresPO->id_program =  $checkExistingTrProgresProgramPR->id_program;
                $AddTrProgramProgresPO->fund_number = $checkExistingTrProgresProgramPR->fund_number;
                $AddTrProgramProgresPO->id_program_jenis_cck =  $checkExistingTrProgresProgramPR->id_program_jenis_cck;
                $AddTrProgramProgresPO->name_program_jenis_cck =  $checkExistingTrProgresProgramPR->name_program_jenis_cck;
                $AddTrProgramProgresPO->fund_center = $checkExistingTrProgresProgramPR->fund_center;
                $AddTrProgramProgresPO->id_program_lokasi_cc =  $checkExistingTrProgresProgramPR->id_program_lokasi_cc;
                $AddTrProgramProgresPO->name_program_lokasi_cc =  $checkExistingTrProgresProgramPR->name_program_lokasi_cc;
                $AddTrProgramProgresPO->name = $checkExistingTrProgresProgramPR->name;
                $AddTrProgramProgresPO->description = $checkExistingTrProgresProgramPR->description;
                $AddTrProgramProgresPO->priority = $checkExistingTrProgresProgramPR->priority;
                $AddTrProgramProgresPO->year = $checkExistingTrProgresProgramPR->year;
                $AddTrProgramProgresPO->nominal = $checkExistingTrProgresProgramPR->nominal;
                $AddTrProgramProgresPO->tr_realisasi = $checkExistingTrProgresProgramPR->tr_realisasi;
                $AddTrProgramProgresPO->id_tr_program_progres_sr = $checkExistingTrProgresProgramPR->id_tr_program_progres_sr;
                $AddTrProgramProgresPO->id_tr_program_progres_pr = $checkExistingTrProgresProgramPR->id;
                $AddTrProgramProgresPO->po_tanggal = $request->form_masterdata_program_po_tanggal;
                $AddTrProgramProgresPO->po_nomor = $request->form_masterdata_program_po_nomor;
                $AddTrProgramProgresPO->po_nominal = $request->form_masterdata_program_po_anggaran;
                $AddTrProgramProgresPO->po_vendor = $request->form_masterdata_program_po_vendor;
                $AddTrProgramProgresPO->po_otorisasi = $request->form_masterdata_program_po_otoritas;
                $AddTrProgramProgresPO->po_tempo = $request->form_masterdata_program_po_tanggal_estimasi;
                $AddTrProgramProgresPO->status =  1;
                $AddTrProgramProgresPO->created_at = Carbon::now();
                $AddTrProgramProgresPO->updated_at = Carbon::now();
                $AddTrProgramProgresPO->created_by = Auth::user()->id;

                $AddTrProgramProgresPO->save();

                $checkExistingTrProgramRealisasi->po_tanggal = $AddTrProgramProgresPO->po_tanggal;
                $checkExistingTrProgramRealisasi->po_nomor = $AddTrProgramProgresPO->po_nomor;
                $checkExistingTrProgramRealisasi->po_nominal =  $total_pengajuan_pr;
                $checkExistingTrProgramRealisasi->po_vendor = $AddTrProgramProgresPO->po_vendor;
                $checkExistingTrProgramRealisasi->po_otorisasi = $AddTrProgramProgresPO->po_otorisasi;
                $checkExistingTrProgramRealisasi->po_tempo = $AddTrProgramProgresPO->po_tempo;
                $checkExistingTrProgramRealisasi->updated_at = Carbon::now();
                $checkExistingTrProgramRealisasi->updated_by = Auth::user()->id;

                $checkExistingTrProgramRealisasi->save();

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

    public function act_detailTrProgresProgramPO(Request $request)
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
            $checkExistingData =  trProgresProgramPO::with('mProgramJenisCCK', 'mProgramLokasiCC','trProgresProgramPROne')->where('uuid', $request->data_id)->orWhere('po_nomor', $request->data_id)->first();
            // dd($checkExistingData);
            
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
    
    private static function onResult($status, $response_code, $message, $data)
    {
        $model['status'] = $status;
        $model['response_code'] = $response_code;
        $model['message'] = $message;
        $model['data'] = $data;
        return response()->json($model, 200);
    }
}
