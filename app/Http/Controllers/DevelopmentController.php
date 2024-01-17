<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
use Maatwebsite\Excel\Facades\Excel;

use Carbon\Carbon;
use App\Http\Controllers\Helpers\mainController;
use Milon\Barcode\DNS1D;
use Milon\Barcode\DNS2D;

// Database
use Illuminate\Support\Facades\DB;

// Export Excell

class DevelopmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function page_indexDevelopment(Request $request)
    {
        return view('welcome');
    } 

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function view_qrcodeDevelopment(Request $request, $file_name)
    {
        $output_file = 'qr-code/bukti-bayar/'.$file_name;

        $image = Storage::disk('public')->get($output_file);

        return response($image, 200)->header('Content-Type', 'image/jpeg');
    } 
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function generate_qrcodeDevelopment(Request $request)
    {
        $time = time();
        $param = [
            'type' => 'bukti-bayar',
            'qr_generate' => 'https://siriska.karawangkab.go.id/',
            'qr_filename' => 'qr-sale-SALE-981207-TNCJ-1701917101-test.png',
            'qr_directory' => 'barcodes/penjualan/',
        ];
        $qrcode = mainController::generateQRCode($param);

        $output_file = $param['qr_directory'].$param['qr_filename'];

        $image = Storage::disk('public')->get($output_file);

        return response($image, 200)->header('Content-Type', 'image/jpeg');
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
