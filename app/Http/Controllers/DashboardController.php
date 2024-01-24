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

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function page_admDashboard(Request $request)
    {
        return redirect()->route('dash.program_anggaran');
        $model['route'] = 'Dashboard Admin';
        
        return view('pages.dashboard.v_index', ['model' => $model]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function page_transaksiDashboard(Request $request)
    {
        $model['route'] = 'Dashboard Admin';
        
        return view('pages.dashboard.v_index', ['model' => $model]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function page_programDashboard(Request $request)
    {
        $model['route'] = 'Dashboard Program Anggaran';
        
        // data
        $model['ms_program'] = mProgram::with('mProgramJenisCCK', 'mProgramLokasiCC')->get();

        return view('pages.dashboard.v_program_anggaran', ['model' => $model]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function page_realisasiDashboard(Request $request)
    {
        $model['route'] = 'Dashboard Realisasi Program';
        
        // data
        $model['ms_program'] = mProgram::with('trProgresProgramSR','trProgresProgramPRMany','trProgresProgramPOMany', 'trProgresProgramGRMany')->get();
        $model['tr_progres_sr'] = trProgresProgramSR::get();
        $model['tr_progres_pr'] = trProgresProgramPR::get();
        $model['tr_progres_po'] = trProgresProgramPO::get();
        $model['tr_progres_gr'] = trProgresProgramGR::get();

        return view('pages.dashboard.v_program_realisasi', ['model' => $model]);
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
