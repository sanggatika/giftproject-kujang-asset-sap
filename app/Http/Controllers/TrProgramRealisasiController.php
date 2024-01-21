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

class TrProgramRealisasiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function page_indexTrProgramRealisasi(Request $request)
    {
        $model['route'] = 'Master Data Program Anggaran';

        $model['ms_program_jenis_cck'] = mProgramJenisCCK::get();
        $model['ms_program_lokasi_cc'] = mProgramLokasiCC::get();

        return view('pages.transaksi-program-realisasi.v_index', ['model' => $model]);
    } 
    
    public function get_datatableTrProgramRealisasi(Request $request)
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
            $form_filter_program_status = $request->form_filter_program_status;
            $form_filter_program_min_anggaran = $request->form_filter_program_min_anggaran;
            $form_filter_program_max_anggaran = $request->form_filter_program_max_anggaran;

            $dataMsProgram = mProgram::whereNotNull('uuid');

            $msProgram = $dataMsProgram->get();
            $jumlahMsProgram = $msProgram->count();
            $totalMsProgramNominal = $msProgram->sum('nominal');

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

            if($form_filter_program_fundnumber != "")
            {
                $dataMsProgram->where('fund_number', 'like', '%'.$form_filter_program_fundnumber.'%');
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

            return DataTables::of($data)
            ->with('jumlahMsProgram', number_format($jumlahMsProgram,0,',','.'))
            ->with('totalMsProgramNominal', number_format($totalMsProgramNominal,0,',','.'))
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
            ->addColumn('fild_mr', function($row)
            {
                $html = '
                <!--begin::User details-->
                <div class="d-flex flex-column text-end">
                    <a href="#" class="text-gray-800 text-hover-primary mb-1 fw-bold"> - </a>
                </div>
                <!--begin::User details-->
                ';

                return $html;
            })
            ->addColumn('fild_pr', function($row)
            {
                $html = '
                <!--begin::User details-->
                <div class="d-flex flex-column text-end">
                    <a href="#" class="text-gray-800 text-hover-primary mb-1 fw-bold"> - </a>
                </div>
                <!--begin::User details-->
                ';

                return $html;
            })
            ->addColumn('fild_po', function($row)
            {
                $html = '
                <!--begin::User details-->
                <div class="d-flex flex-column text-end">
                    <a href="#" class="text-gray-800 text-hover-primary mb-1 fw-bold"> - </a>
                </div>
                <!--begin::User details-->
                ';

                return $html;
            })
            ->addColumn('fild_gr', function($row)
            {
                $html = '
                <!--begin::User details-->
                <div class="d-flex flex-column text-end">
                    <a href="#" class="text-gray-800 text-hover-primary mb-1 fw-bold"> - </a>
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
                        <li><a class="dropdown-item" href="#" data-id="'.$row->uuid.'" onclick="act_btnDetailData(this)">Detail Data</a></li>
                    </ul>
                </div>
                ';

                return $html;
            })
            ->rawColumns(['fund_number', 'fild_name', 'fild_nominal', 'fild_mr', 'fild_pr', 'fild_po', 'fild_gr', 'action'])
            ->make(true);
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
