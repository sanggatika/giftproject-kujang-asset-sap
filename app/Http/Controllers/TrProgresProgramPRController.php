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
use App\Models\trProgramRealisasi;

class TrProgresProgramPRController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function page_indexTrProgresProgramPR(Request $request)
    {
        $model['route'] = 'Master Data Program Anggaran';

        $model['ms_program_jenis_cck'] = mProgramJenisCCK::get();
        $model['ms_program_lokasi_cc'] = mProgramLokasiCC::get();

        return view('pages.transaksi-progres-program-pr.v_index', ['model' => $model]);
    }    
    
    public function get_datatableTrProgresProgramPR(Request $request)
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

            $form_filter_program_pr_nomor = $request->form_filter_program_pr_nomor;
            $form_filter_program_pr_tanggal = $request->form_filter_program_pr_tanggal;
            $form_filter_program_min_anggaran = $request->form_filter_program_min_anggaran;
            $form_filter_program_max_anggaran = $request->form_filter_program_max_anggaran;

            $dataTrProgresProgramPR = trProgresProgramPR::whereNotNull('uuid');

            $trProgresProgramPR = $dataTrProgresProgramPR->get();
            $jumlahtrProgresProgramPR = $trProgresProgramPR->count();
            $totaltrProgresProgramPRNominal = $trProgresProgramPR->sum('pr_nominal');

            // Filter Data
            if($form_filter_program != "")
            {
                $dataTrProgresProgramPR->where('name', 'like', '%'.$form_filter_program.'%');
            }

            if($form_filter_program_jenis != "-")
            {
                $checkExistingDataProgramJenis =  mProgramJenisCCK::where('uuid', $request->form_filter_program_jenis)->first();
                $dataTrProgresProgramPR->where('id_program_jenis_cck', $checkExistingDataProgramJenis->id);
            }

            if($form_filter_program_lokasi != "-")
            {
                $checkExistingDataProgramLokasi =  mProgramLokasiCC::where('uuid', $request->form_filter_program_lokasi)->first();
                $dataTrProgresProgramPR->where('id_program_lokasi_cc', $checkExistingDataProgramLokasi->id);
            }

            if($form_filter_program_priority != "-")
            {
                $dataTrProgresProgramPR->where('priority', $request->form_filter_program_priority);
            }

            if($form_filter_program_pr_nomor != "")
            {
                $dataTrProgresProgramPR->where('pr_nomor', 'like', '%'.$form_filter_program_pr_nomor.'%');
            }

            // Filter Data
            if($form_filter_program_pr_tanggal != "")
            {
                $explode_filter_program_pr_tanggal = explode(' to ', $form_filter_program_pr_tanggal);
                $form_filter_startdate = $explode_filter_program_pr_tanggal[0];
                $form_filter_enddate = $explode_filter_program_pr_tanggal[1];

                $dataTrProgresProgramPR->whereBetween('created_at', [$form_filter_startdate.' 00:00:01', $form_filter_enddate.' 23:59:59']);
            }

            if($form_filter_program_min_anggaran != "")
            {
                $minAnggaran = intval($form_filter_program_min_anggaran);
                $dataTrProgresProgramPR->where('nominal', '>=', $minAnggaran);
            }

            if($form_filter_program_max_anggaran != "")
            {
                $maxAnggaran = intval($form_filter_program_max_anggaran);
                $dataTrProgresProgramPR->where('nominal', '<=', $maxAnggaran);
            }

            $trProgresProgramPRSelesai = $dataTrProgresProgramPR->get();
            $jumlahtrProgresProgramPRSelesai = $trProgresProgramPRSelesai->where('status', '!=', 1)->count();
            $totaltrProgresProgramPRNominalSelesai = $trProgresProgramPRSelesai->where('status', '!=', 1)->sum('pr_nominal');

            $persentasetrProgresProgramPRNominalSelesai = ($totaltrProgresProgramPRNominalSelesai / $totaltrProgresProgramPRNominal) * 100;

            // Menampilkan Data Hanya Belum Realisasi
            $dataTrProgresProgramPR->where('status', 1);

            $data = $dataTrProgresProgramPR->get();

            $jumlahtrProgresProgramPRProses = $data->count();
            $totaltrProgresProgramPRNominalProses = $data->sum('pr_nominal');

            return DataTables::of($data)
            ->with('jumlahtrProgresProgramPR', number_format($jumlahtrProgresProgramPR,0,',','.'))
            ->with('totaltrProgresProgramPRNominal', number_format($totaltrProgresProgramPRNominal,0,',','.'))
            ->with('jumlahtrProgresProgramPRSelesai', number_format($jumlahtrProgresProgramPRSelesai,0,',','.'))
            ->with('totaltrProgresProgramPRNominalSelesai', number_format($totaltrProgresProgramPRNominalSelesai,0,',','.'))
            ->with('persentasetrProgresProgramPRNominalSelesai', number_format($persentasetrProgresProgramPRNominalSelesai,0,',','.'))
            ->with('jumlahtrProgresProgramPRProses', number_format($jumlahtrProgresProgramPRProses,0,',','.'))
            ->with('totaltrProgresProgramPRNominalProses', number_format($totaltrProgresProgramPRNominalProses,0,',','.'))
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
                $tanggal = Carbon::parse($row->pr_tanggal)->format('d F Y');
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
                $nomor = $row->pr_nomor;
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
                $nominal_fix = number_format($row->pr_nominal,0,',','.');
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
                        <li><a class="dropdown-item" href="#" data-id="'.$row->uuid.'" onclick="act_btnPurchaseOrder(this)">Purchase Order (PO)</a></li>
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

    public function act_tambahTrProgresProgramPR(Request $request)
    {
        $status = false;
        $response_code = 'RC400';
        $message = 'Data Gagal Disimpan Terjadi Gangguan..';
        $dataAPI = null;

        if ($request->ajax()) {  
            // dd($request->all());          
            $validator = Validator::make($request->all(), [
                'form_masterdata_program_fundnumber' => 'required',
                'form_masterdata_program_uuid' => 'required',
                'form_masterdata_program_pr_tanggal' => 'required',
                'form_masterdata_program_pr_nomor' => 'required',
                'form_masterdata_program_pr_anggaran' => 'required',
            ]);

            // Ketika data kiriman tidak sesuai
            if ($validator->fails())
            {
                $response_code = "RC400";
                $message = "Form Tidak Tervalidasi Dengan Sistem";
                return $this->onResult($status, $response_code, $message, $dataAPI);
            }

            // Cek Data Dalam Database
            $checkExistingTrProgresProgramSR =  trProgresProgramSR::with('trProgresProgramPR')->where('uuid', $request->form_masterdata_program_uuid)->first();
            // dd($checkExistingTrProgresProgramSR);

            if(!$checkExistingTrProgresProgramSR)
            {
                $response_code = "RC400";
                $message = "Transaksi Progres Program SR Tidak Ada Dalam Sistem";
                return $this->onResult($status, $response_code, $message, $dataAPI);
            }

            $total_pengajuan_sr = 0;
            if($checkExistingTrProgresProgramSR->trProgresProgramPR)
            {
                $interval_pengajuan = $checkExistingTrProgresProgramSR->trProgresProgramPR->sum('pr_nominal') + intval($request->form_masterdata_program_pr_anggaran);
                // dd($interval_pengajuan);
                if($interval_pengajuan > $checkExistingTrProgresProgramSR->sr_nominal)
                {
                    $response_code = "RC400";
                    $message = "Pengajuan Purchase Requisition (PR) Melebihi Anggaran";
                    return $this->onResult($status, $response_code, $message, $dataAPI);
                }

                $total_pengajuan_sr = $interval_pengajuan;
            }
            // dd($total_pengajuan_sr);

            // Cek Data Dalam Database
            $checkExistingTrProgramRealisasi =  trProgramRealisasi::where('id_program', $checkExistingTrProgresProgramSR->id_program)->first();
            if(!$checkExistingTrProgramRealisasi)
            {
                $response_code = "RC400";
                $message = "Realisasi Program Tidak Ada Dalam Database";
                return $this->onResult($status, $response_code, $message, $dataAPI);
            }

            $tr_realisasi =  $checkExistingTrProgramRealisasi->tr_realisasi + 1;
            // dd($tr_realisasi);

            $permitted_chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $nomor_registrasi = "TRPROGPR-".random_int(10, 99).date('m').date('d')."-".substr(str_shuffle($permitted_chars), 0, 4)."-".time();

            // Validasi Ketika Gagal Melakukan Transaksi Data Akan Di Rollback
            DB::beginTransaction();

            try {    
                // Proses Simpan Data Kedalam Database      
                $AddTrProgramProgresPR = new trProgresProgramPR();

                $AddTrProgramProgresPR->uuid =  (string) Str::uuid();
                $AddTrProgramProgresPR->code =  $nomor_registrasi;
                $AddTrProgramProgresPR->id_program =  $checkExistingTrProgresProgramSR->id_program;
                $AddTrProgramProgresPR->fund_number = $checkExistingTrProgresProgramSR->fund_number;
                $AddTrProgramProgresPR->id_program_jenis_cck =  $checkExistingTrProgresProgramSR->id_program_jenis_cck;
                $AddTrProgramProgresPR->name_program_jenis_cck =  $checkExistingTrProgresProgramSR->name_program_jenis_cck;
                $AddTrProgramProgresPR->fund_center = $checkExistingTrProgresProgramSR->fund_center;
                $AddTrProgramProgresPR->id_program_lokasi_cc =  $checkExistingTrProgresProgramSR->id_program_lokasi_cc;
                $AddTrProgramProgresPR->name_program_lokasi_cc =  $checkExistingTrProgresProgramSR->name_program_lokasi_cc;
                $AddTrProgramProgresPR->name = $checkExistingTrProgresProgramSR->name;
                $AddTrProgramProgresPR->description = $checkExistingTrProgresProgramSR->description;
                $AddTrProgramProgresPR->priority = $checkExistingTrProgresProgramSR->priority;
                $AddTrProgramProgresPR->year = $checkExistingTrProgresProgramSR->year;
                $AddTrProgramProgresPR->nominal = $checkExistingTrProgresProgramSR->nominal;
                $AddTrProgramProgresPR->tr_realisasi = $tr_realisasi;
                $AddTrProgramProgresPR->id_tr_program_progres_sr = $checkExistingTrProgresProgramSR->id;
                $AddTrProgramProgresPR->pr_tanggal = $request->form_masterdata_program_pr_tanggal;
                $AddTrProgramProgresPR->pr_nomor = $request->form_masterdata_program_pr_nomor;
                $AddTrProgramProgresPR->pr_nominal = $request->form_masterdata_program_pr_anggaran;
                $AddTrProgramProgresPR->pr_vendor = $request->form_masterdata_program_pr_vendor;
                $AddTrProgramProgresPR->status =  1;
                $AddTrProgramProgresPR->created_at = Carbon::now();
                $AddTrProgramProgresPR->updated_at = Carbon::now();
                $AddTrProgramProgresPR->created_by = Auth::user()->id;

                $AddTrProgramProgresPR->save();

                $checkExistingTrProgramRealisasi->tr_realisasi = $AddTrProgramProgresPR->tr_realisasi;
                $checkExistingTrProgramRealisasi->pr_tanggal = $AddTrProgramProgresPR->pr_tanggal;
                $checkExistingTrProgramRealisasi->pr_nomor = $AddTrProgramProgresPR->pr_nomor;
                $checkExistingTrProgramRealisasi->pr_nominal = $total_pengajuan_sr;
                $checkExistingTrProgramRealisasi->pr_vendor = $AddTrProgramProgresPR->pr_vendor;
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

    public function act_detailTrProgresProgramPR(Request $request)
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
            $checkExistingData =  trProgresProgramPR::with('mProgramJenisCCK', 'mProgramLokasiCC')->where('uuid', $request->data_id)->orWhere('pr_nomor', $request->data_id)->first();

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
