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
use App\Models\trProgresProgramGR;
use App\Models\trProgramRealisasi;

class TrProgresProgramGRController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function page_indexTrProgresProgramGR(Request $request)
    {
        $model['route'] = 'Master Data Program Anggaran';

        $model['ms_program_jenis_cck'] = mProgramJenisCCK::get();
        $model['ms_program_lokasi_cc'] = mProgramLokasiCC::get();

        return view('pages.transaksi-progres-program-gr.v_index', ['model' => $model]);
    } 

    public function get_datatableTrProgresProgramGR(Request $request)
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

            $form_filter_program_gr_nomor = $request->form_filter_program_gr_nomor;
            $form_filter_program_min_anggaran = $request->form_filter_program_min_anggaran;
            $form_filter_program_max_anggaran = $request->form_filter_program_max_anggaran;

            $form_filter_program_gr_tanggal = $request->form_filter_program_gr_tanggal;            

            $dataTrProgresProgramGR = trProgresProgramGR::with('trProgresProgramPR', 'trProgresProgramPO')->whereNotNull('uuid');

            $jumlahMsProgram = mProgram::whereNotNull('uuid')->count();
            $totalMsProgramNominal = mProgram::whereNotNull('uuid')->sum('nominal');

            // Filter Data
            if($form_filter_program != "")
            {
                $dataTrProgresProgramGR->where('name', 'like', '%'.$form_filter_program.'%')->orWhere('fund_number',$form_filter_program);
            }

            if($form_filter_program_jenis != "-")
            {
                $checkExistingDataProgramJenis =  mProgramJenisCCK::where('uuid', $request->form_filter_program_jenis)->first();
                $dataTrProgresProgramGR->where('id_program_jenis_cck', $checkExistingDataProgramJenis->id);
            }

            if($form_filter_program_lokasi != "-")
            {
                $checkExistingDataProgramLokasi =  mProgramLokasiCC::where('uuid', $request->form_filter_program_lokasi)->first();
                $dataTrProgresProgramGR->where('id_program_lokasi_cc', $checkExistingDataProgramLokasi->id);
            }

            if($form_filter_program_priority != "-")
            {
                $dataTrProgresProgramGR->where('priority', $request->form_filter_program_priority);
            }

            if($form_filter_program_gr_nomor != "")
            {
                $dataTrProgresProgramGR->where('gr_nomor', $form_filter_program_gr_nomor);
            }

            // Filter Data
            if($form_filter_program_gr_tanggal != "")
            {
                $explode_filter_program_gr_tanggal = explode(' to ', $form_filter_program_gr_tanggal);
                $form_filter_startdate = $explode_filter_program_gr_tanggal[0];
                $form_filter_enddate = $explode_filter_program_gr_tanggal[1];

                $dataTrProgresProgramGR->whereBetween('created_at', [$form_filter_startdate.' 00:00:01', $form_filter_enddate.' 23:59:59']);
            }

            if($form_filter_program_min_anggaran != "")
            {
                $minAnggaran = intval($form_filter_program_min_anggaran);
                $dataTrProgresProgramGR->where('nominal', '>=', $minAnggaran);
            }

            if($form_filter_program_max_anggaran != "")
            {
                $maxAnggaran = intval($form_filter_program_max_anggaran);
                $dataTrProgresProgramGR->where('nominal', '<=', $maxAnggaran);
            }

            $data = $dataTrProgresProgramGR->get();
            $jumlahFilterProgresProgramRealisasi = $data->count();
            $totalFilterProgresProgramRealisasi = $data->sum('gr_nominal');
            $totalFilterProgresProgramRealisasiSisa = $totalMsProgramNominal - $totalFilterProgresProgramRealisasi;
            $persentaseFilterProgresProgramRealisasi = ($totalFilterProgresProgramRealisasi / $totalMsProgramNominal) * 100;
            
            // dd($totalFilterProgresProgramRealisasi);

            return DataTables::of($data)
            ->with('jumlahMsProgram', number_format($jumlahMsProgram,0,',','.'))
            ->with('totalMsProgramNominal', number_format($totalMsProgramNominal,0,',','.'))
            ->with('jumlahFilterProgresProgramRealisasi', number_format($jumlahFilterProgresProgramRealisasi,0,',','.'))
            ->with('totalFilterProgresProgramRealisasi', number_format($totalFilterProgresProgramRealisasi,0,',','.'))
            ->with('totalFilterProgresProgramRealisasiSisa', number_format($totalFilterProgresProgramRealisasiSisa,0,',','.'))
            ->with('persentaseFilterProgresProgramRealisasi', $persentaseFilterProgresProgramRealisasi)
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
            ->addColumn('fild_pr', function($row)
            {   
                $nomor_pr = $row->trProgresProgramPR->pr_nomor;
                $nominal_pr = number_format($row->trProgresProgramPR->pr_nominal,0,',','.');
                $tanggal_pr = Carbon::parse($row->trProgresProgramPR->pr_tanggal)->format('d F Y');
                
                $html = '
                <!--begin::User details-->
                <div class="d-flex flex-column text-end">                    
                    <a href="#" class="text-gray-800 text-hover-primary mb-1 fw-bolder fs-5">'.$nominal_pr.'</a>
                    <small>'.$nomor_pr.'</small>
                    <hr>
                    <a href="#" class="text-gray-800 text-hover-primary mb-1 fw-bold">'.$tanggal_pr.'</a>
                </div>
                <!--begin::User details-->
                ';

                return $html;
            })
            ->addColumn('fild_po', function($row)
            {   
                $nomor_po = $row->trProgresProgramPO->po_nomor;
                $nominal_po = number_format($row->trProgresProgramPO->po_nominal,0,',','.');
                $tanggal_po = Carbon::parse($row->trProgresProgramPO->po_tanggal)->format('d F Y');
                $tanggal_estimasi_po = Carbon::parse($row->trProgresProgramPO->po_tempo)->format('d F Y');
                
                $html = '
                <!--begin::User details-->
                <div class="d-flex flex-column text-end">                    
                    <a href="#" class="text-gray-800 text-hover-primary mb-1 fw-bolder fs-5">'.$nominal_po.'</a>
                    <small>'.$nomor_po.'</small>
                    <hr>
                    <a href="#" class="text-gray-800 text-hover-primary mb-1 fw-bold">'.$tanggal_po.' - '.$tanggal_estimasi_po.'</a>
                </div>
                <!--begin::User details-->
                ';

                return $html;
            })
            ->addColumn('fild_gr', function($row)
            {   
                $nomor_gr = $row->gr_nomor;
                $nominal_gr = number_format($row->gr_nominal,0,',','.');
                $tanggal_gr = Carbon::parse($row->gr_tanggal)->format('d F Y');
                
                $html = '
                <!--begin::User details-->
                <div class="d-flex flex-column text-end">                    
                    <a href="#" class="text-gray-800 text-hover-primary mb-1 fw-bolder fs-5">'.$nominal_gr.'</a>
                    <small>'.$nomor_gr.'</small>
                    <hr>
                    <a href="#" class="text-gray-800 text-hover-primary mb-1 fw-bold">'.$tanggal_gr.'</a>
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
                    </ul>
                </div>
                ';

                return $html;
            })
            ->rawColumns(['fund_number', 'fild_name', 'fild_nominal', 'fild_pr', 'fild_po', 'fild_gr',  'action'])
            ->make(true);
        }
        return $this->onResult($status, $response_code, $message, $dataAPI);
    }

    public function act_tambahTrProgresProgramGR(Request $request)
    {
        $status = false;
        $response_code = 'RC400';
        $message = 'Data Gagal Disimpan Terjadi Gangguan..';
        $dataAPI = null;

        if ($request->ajax()) {  
            // dd($request->all());          
            $validator = Validator::make($request->all(), [
                'form_masterdata_program_po_nomor' => 'required',
                'form_masterdata_program_po_uuid' => 'required',
                'form_masterdata_program_gr_tanggal' => 'required',
                'form_masterdata_program_gr_nomor' => 'required',
                'form_masterdata_program_gr_anggaran' => 'required'
            ]);

            // Ketika data kiriman tidak sesuai
            if ($validator->fails())
            {
                $response_code = "RC400";
                $message = "Form Tidak Tervalidasi Dengan Sistem";
                return $this->onResult($status, $response_code, $message, $dataAPI);
            }

            // Cek Data Dalam Database
            $checkExistingTrProgresProgramPO =  trProgresProgramPO::where('uuid', $request->form_masterdata_program_po_uuid)->first();
            // dd($checkExistingTrProgresProgramSR);

            if(!$checkExistingTrProgresProgramPO)
            {
                $response_code = "RC400";
                $message = "Transaksi Progres Program PR Tidak Ada Dalam Sistem";
                return $this->onResult($status, $response_code, $message, $dataAPI);
            }

            // dd($checkExistingTrProgramRealisasi);

            $permitted_chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $nomor_registrasi = "TRPROGGR-".random_int(10, 99).date('m').date('d')."-".substr(str_shuffle($permitted_chars), 0, 4)."-".time();

            // Validasi Ketika Gagal Melakukan Transaksi Data Akan Di Rollback
            DB::beginTransaction();

            try {    
                // Proses Simpan Data Kedalam Database      
                $AddTrProgramProgresGR = new trProgresProgramGR();

                $AddTrProgramProgresGR->uuid =  (string) Str::uuid();
                $AddTrProgramProgresGR->code =  $nomor_registrasi;
                $AddTrProgramProgresGR->id_program =  $checkExistingTrProgresProgramPO->id_program;
                $AddTrProgramProgresGR->fund_number = $checkExistingTrProgresProgramPO->fund_number;
                $AddTrProgramProgresGR->id_program_jenis_cck =  $checkExistingTrProgresProgramPO->id_program_jenis_cck;
                $AddTrProgramProgresGR->name_program_jenis_cck =  $checkExistingTrProgresProgramPO->name_program_jenis_cck;
                $AddTrProgramProgresGR->fund_center = $checkExistingTrProgresProgramPO->fund_center;
                $AddTrProgramProgresGR->id_program_lokasi_cc =  $checkExistingTrProgresProgramPO->id_program_lokasi_cc;
                $AddTrProgramProgresGR->name_program_lokasi_cc =  $checkExistingTrProgresProgramPO->name_program_lokasi_cc;
                $AddTrProgramProgresGR->name = $checkExistingTrProgresProgramPO->name;
                $AddTrProgramProgresGR->description = $checkExistingTrProgresProgramPO->description;
                $AddTrProgramProgresGR->priority = $checkExistingTrProgresProgramPO->priority;
                $AddTrProgramProgresGR->year = $checkExistingTrProgresProgramPO->year;
                $AddTrProgramProgresGR->nominal = $checkExistingTrProgresProgramPO->nominal;
                $AddTrProgramProgresGR->tr_realisasi = $checkExistingTrProgresProgramPO->tr_realisasi;
                $AddTrProgramProgresGR->id_tr_program_progres_sr = $checkExistingTrProgresProgramPO->id_tr_program_progres_sr;
                $AddTrProgramProgresGR->id_tr_program_progres_pr = $checkExistingTrProgresProgramPO->id_tr_program_progres_pr;
                $AddTrProgramProgresGR->id_tr_program_progres_po = $checkExistingTrProgresProgramPO->id;
                $AddTrProgramProgresGR->gr_tanggal = $request->form_masterdata_program_gr_tanggal;
                $AddTrProgramProgresGR->gr_nomor = $request->form_masterdata_program_gr_nomor;
                $AddTrProgramProgresGR->gr_nominal = $request->form_masterdata_program_gr_anggaran;
                $AddTrProgramProgresGR->status =  1;
                $AddTrProgramProgresGR->created_at = Carbon::now();
                $AddTrProgramProgresGR->updated_at = Carbon::now();
                $AddTrProgramProgresGR->created_by = Auth::user()->id;

                $AddTrProgramProgresGR->save();

                // Purchase Order (PO) -> Good Receipt (GR)

                $checkExistingTrProgresProgramPO->status =  2;
                $checkExistingTrProgresProgramPO->updated_at = Carbon::now();
                $checkExistingTrProgresProgramPO->updated_by = Auth::user()->id;

                $checkExistingTrProgresProgramPO->save();

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

    public function act_detailTrProgresProgramGR(Request $request)
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
            $checkExistingData =  trProgresProgramGR::with('mProgramJenisCCK', 'mProgramLokasiCC','trProgresProgramPO')->where('uuid', $request->data_id)->orWhere('gr_nomor', $request->data_id)->first();
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
