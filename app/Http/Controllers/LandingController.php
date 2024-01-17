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
use App\Models\mBarangJenis;
use App\Models\mSatuan;
use App\Models\mBarang;
use App\Models\mCustomer;
use App\Models\trInventoryAsset;
use App\Models\trPurchases;
use App\Models\trPurchasesDetail;
use App\Models\trPenjualan;
use App\Models\trPenjualanDetail;
use App\Models\trPenjualanFake;
use App\Models\trPenjualanFakeDetail;
use App\Models\trKeuangan;

class LandingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function page_homeLanding(Request $request)
    {

        $model['route'] = 'Public Home';
        
        return view('pages.publik.beranda.v_beranda', ['model' => $model]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function page_trackingPurchasesLanding(Request $request, $data_uuid)
    {
        $model['route'] = 'Transaksi Detail Penjualan';
        
        $model['trpurchases'] = trPurchases::with('mSupplier', 'trPurchasesDetail')->where('uuid', $data_uuid)->first();

        return view('pages.publik.tracking.v_purchases', ['model' => $model]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function page_trackingPenjualanFakeLanding(Request $request, $data_uuid)
    {
        $model['route'] = 'Transaksi Detail Penjualan';
        
        $model['trpenjualan'] = trPenjualan::with('mCustomer', 'trPenjualanDetail')->where('uuid', $data_uuid)->first();

        return view('pages.publik.tracking.v_penjualan', ['model' => $model]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function page_trackingPenjualanLanding(Request $request, $data_uuid)
    {
        $model['route'] = 'Transaksi Detail Penjualan';
        
        $model['trpenjualan'] = trPenjualanFake::with('mCustomer', 'trPenjualanFakeDetail')->where('uuid', $data_uuid)->first();

        return view('pages.publik.tracking.v_penjualan_fake', ['model' => $model]);
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
