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

class TrProgramPrognosaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function page_indexTrProgramPrognosa(Request $request)
    {
        $model['route'] = 'Master Data Program Anggaran';

        $model['ms_program_jenis_cck'] = mProgramJenisCCK::get();
        $model['ms_program_lokasi_cc'] = mProgramLokasiCC::get();

        return view('pages.transaksi-program-prognosa.v_index', ['model' => $model]);
    } 

    public function get_datatableTrProgramPrognosa(Request $request)
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
            $form_filter_tanggal_cutoff = $request->form_filter_tanggal_cutoff;
            $form_filter_program_min_anggaran = $request->form_filter_program_min_anggaran;
            $form_filter_program_max_anggaran = $request->form_filter_program_max_anggaran;

            $dataMsProgram = mProgram::with('trProgresProgramSR','trProgresProgramPRMany','trProgresProgramPOMany', 'trProgresProgramGRMany')->whereNotNull('uuid');

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

            // Rumus Pronosa
            // MR/SR -> PR = 30 Hari
            // PR -> PO = 40 Hari
            // PO -> GR = 60 Hari / 90 Hari
            // Estimasi = 130 Hari

            $jumlahFilterMsProgram = $data->count();
            $totalFilterMsProgramNominal = $data->sum('nominal');
            
            // $data_tr_pr = $data_tr_pr->where('pr_tanggal', '<', Carbon::parse($form_filter_tanggal_cutoff)->subDays(100));
            $totalTrPrognosaPR = $data->pluck('trProgresProgramPRMany')->flatten()->where('status', 1)->where('pr_tanggal', '<', Carbon::parse($form_filter_tanggal_cutoff)->subDays(100))->sum('pr_nominal');
            $totalTrPrognosaPO = $data->pluck('trProgresProgramPOMany')->flatten()->where('status', 1)->where('po_tanggal', '<', Carbon::parse($form_filter_tanggal_cutoff)->subDays(60))->sum('po_nominal');
            $totalTrPrognosaGR = $data->pluck('trProgresProgramGRMany')->flatten()->sum('gr_nominal');

            $totalMsProgramPrognosa = $totalTrPrognosaPR + $totalTrPrognosaPO + $totalTrPrognosaGR;

            return DataTables::of($data)
            ->with('jumlahMsProgram', number_format($jumlahMsProgram,0,',','.'))
            ->with('totalMsProgramNominal', number_format($totalMsProgramNominal,0,',','.'))
            ->with('jumlahFilterMsProgram', number_format($jumlahFilterMsProgram,0,',','.'))
            ->with('totalFilterMsProgramNominal', number_format($totalFilterMsProgramNominal,0,',','.'))
            ->with('totalTrPrognosaPR', number_format($totalTrPrognosaPR,0,',','.'))
            ->with('totalTrPrognosaPO', number_format($totalTrPrognosaPO,0,',','.'))
            ->with('totalTrPrognosaGR', number_format($totalTrPrognosaGR,0,',','.'))
            ->with('totalMsProgramPrognosa', number_format($totalMsProgramPrognosa,0,',','.'))
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
                $nominal_sr = 0;
                if($row->trProgresProgramSR)
                {
                    $nominal_sr = $row->trProgresProgramSR->sr_nominal;
                }
                
                $html = '
                <!--begin::User details-->
                <div class="d-flex flex-column text-end">
                    <a href="#" class="text-gray-800 text-hover-primary mb-1 fw-bold">'.number_format($nominal_sr,0,',','.').'</a>
                </div>
                <!--begin::User details-->
                ';

                return $html;
            })            
            ->addColumn('fild_gr', function($row)
            {
                $nominal_gr = 0;
                if($row->trProgresProgramGRMany)
                {
                    $nominal_gr = $row->trProgresProgramGRMany->where('status', 1)->sum('gr_nominal');
                }

                $persentase_realisasi = ( $nominal_gr / $row->nominal ) * 100;

                $html = '
                <!--begin::User details-->
                <div class="d-flex flex-column text-end">
                    <a href="#" class="text-gray-800 text-hover-primary mb-1 fw-bold">'.number_format($nominal_gr,0,',','.').'</a>
                    <small>'.number_format($persentase_realisasi,2,',','.').' % </small>
                    <hr>
                </div>
                <!--begin::User details-->
                ';

                return $html;
            })
            ->addColumn('fild_prognosa', function($row) use ($form_filter_tanggal_cutoff)
            {
                // Rumus Pronosa
                // MR/SR -> PR = 30 Hari
                // PR -> PO = 40 Hari
                // PO -> GR = 60 Hari / 90 Hari
                // Estimasi = 130 Hari

                $nominal_pr = 0;
                if($row->trProgresProgramPRMany)
                {
                    $data_tr_pr = $row->trProgresProgramPRMany->where('status', 1);

                    if($form_filter_tanggal_cutoff)
                    {
                        $data_tr_pr = $data_tr_pr->where('pr_tanggal', '<', Carbon::parse($form_filter_tanggal_cutoff)->subDays(100));
                    }                 

                    $nominal_pr = $data_tr_pr->sum('pr_nominal');
                }

                $nominal_po = 0;
                if($row->trProgresProgramPOMany)
                {
                    $data_tr_po = $row->trProgresProgramPOMany->where('status', 1);

                    if($form_filter_tanggal_cutoff)
                    {
                        $data_tr_po = $data_tr_po->where('po_tanggal', '<', Carbon::parse($form_filter_tanggal_cutoff)->subDays(60));
                    }                 

                    $nominal_po = $data_tr_po->sum('pr_nominal');
                }

                $nominal_gr = 0;
                if($row->trProgresProgramGRMany)
                {
                    $nominal_gr = $row->trProgresProgramGRMany->where('status', 1)->sum('gr_nominal');
                }

                $nominal_prognosa = $nominal_pr + $nominal_po + $nominal_gr;
                $persentase_prognosa = ( $nominal_prognosa / $row->nominal ) * 100;

                $html = '
                <!--begin::User details-->
                <div class="d-flex flex-column text-end">
                    <a href="#" class="text-gray-800 text-hover-primary mb-1 fw-bold">'.number_format($nominal_prognosa,0,',','.').'</a>
                    <small>'.number_format($persentase_prognosa,2,',','.').' % </small>
                    <hr>
                </div>
                <!--begin::User details-->
                ';

                return $html;
            })
            ->addColumn('fild_sisa', function($row) use ($form_filter_tanggal_cutoff)
            {
                $nominal_pr = 0;
                if($row->trProgresProgramPRMany)
                {
                    $data_tr_pr = $row->trProgresProgramPRMany->where('status', 1);

                    if($form_filter_tanggal_cutoff)
                    {
                        $data_tr_pr = $data_tr_pr->where('pr_tanggal', '<', Carbon::parse($form_filter_tanggal_cutoff)->subDays(100));
                    }                 

                    $nominal_pr = $data_tr_pr->sum('pr_nominal');
                }

                $nominal_po = 0;
                if($row->trProgresProgramPOMany)
                {
                    $data_tr_po = $row->trProgresProgramPOMany->where('status', 1);

                    if($form_filter_tanggal_cutoff)
                    {
                        $data_tr_po = $data_tr_po->where('po_tanggal', '<', Carbon::parse($form_filter_tanggal_cutoff)->subDays(60));
                    }                 

                    $nominal_po = $data_tr_po->sum('pr_nominal');
                }

                $nominal_gr = 0;
                if($row->trProgresProgramGRMany)
                {
                    $nominal_gr = $row->trProgresProgramGRMany->where('status', 1)->sum('gr_nominal');
                }

                $nominal_prognosa = $nominal_pr + $nominal_po + $nominal_gr;
                $nominal_sisaanggaran = $row->nominal - $nominal_prognosa;

                $persentase_sisa = ( $nominal_sisaanggaran / $row->nominal ) * 100;

                $html = '
                <!--begin::User details-->
                <div class="d-flex flex-column text-end">
                    <a href="#" class="text-gray-800 text-hover-primary mb-1 fw-bold">'.number_format($nominal_sisaanggaran,0,',','.').'</a>
                    <small>'.number_format($persentase_sisa,2,',','.').' % </small>
                    <hr>
                </div>
                <!--begin::User details-->
                ';

                return $html;
            })
            ->rawColumns(['fund_number', 'fild_name', 'fild_nominal', 'fild_mr', 'fild_gr', 'fild_prognosa', 'fild_sisa'])
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
