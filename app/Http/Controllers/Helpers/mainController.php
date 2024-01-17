<?php
 
namespace App\Http\Controllers\Helpers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;

use Jenssegers\Agent\Agent;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use PDF;
 
class mainController extends Controller
{
    public static function getClientAgent()
    {   
        $agent = new Agent();

        $browser = $agent->browser();
        $browser_version = $agent->version($browser);

        $platform = $agent->platform();

        $device = $agent->device();
        $desktop = $agent->isDesktop();
        $phone = $agent->isPhone();
        $robot = $agent->isRobot();

        return [
            'browser' => $browser,
            'browser_version' => $browser_version,
            'platform' => $platform,
            'device' => $device,
            'desktop' => $desktop,
            'phone' => $phone,
            'robot' => $robot,
        ];
    }

    public static function checkStrengthPassword($tmp_password){
        $password = $tmp_password;

        $uppercase = preg_match('@[A-Z]@', $password);
        $lowercase = preg_match('@[a-z]@', $password);
        $number    = preg_match('@[0-9]@', $password);
        $specialChars = preg_match('@[^\w]@', $password);

        if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8)
        {
            return false;
        }else{
            return true;
        }
    }

    public static function sendEmailAWS($data)
    {
        try {
            $response = Http::withoutVerifying()->withBasicAuth(env('API_USER', 'localhost'), env('API_PASS', '1'))->post(
                env('API_URL').'/api/v1/email/sender_aws',
                [
                    'to' => $data['to'],
                    'subject' => $data['subject'],
                    'html' => $data['html'],
                    'from_name' => 'Starterkit Metronic - Laravel 10'
                ]
            );
            $responseData = $response->json();

            $errorMsg = [
                'RC200' => 'Sukses',
                'RC400' => 'Bad Request - Error Server',
                'RC401' => 'Unauthorized (RFC 7235) - Tidak Mempunyai Akses',
                'RC403' => 'Forbidden - URL Tidak Bisa D akses',
                'RC404' => 'Not Found - Tidak Ditemukan',
                'RC405' => 'Method Not Allowed - Format'
            ];

            if($responseData['status'] === false){
                return [
                    'state' => false,
                    'message' => $errorMsg[$responseData['response_code']],
                    'data' => $responseData
                ];
            }
            return [
                'state' => true,
                'message' => 'Sukses mengirimkan email',
                'response' => $response->json()
            ];
        } catch (\Throwable $th) {
            Log::critical($th);
            return [
                'state' => false,
                'error' => $th->getMessage()
            ];
        }
    }

    public static function generateQRCode($param = null)
    {
        try {
            if($param['type'] == 'bukti-bayar')
            {
                $from = [255, 0, 0];
                $to = [0, 0, 255];
                
                $image = QrCode::format('png')
                    ->size(750)
                    ->errorCorrection('H')
                    ->margin(2)
                    ->style('dot')
                    ->eye('circle')
                    ->gradient($from[0], $from[1], $from[2], $to[0], $to[1], $to[2], 'diagonal')
                    ->merge(public_path()."/images/logo-qr-giftproject.png", .30, true)
                    ->generate($param['qr_generate']);
            }

            $output_file = $param['qr_directory'].$param['qr_filename'];

            Storage::disk('public')->put($output_file, $image);

            return $param['qr_filename'];
        } catch (\Throwable $error) {
            Log::critical($error);
            
            return null;
        }        
    }

    public static function dokumenSuratKetetapanRetribusi($param = null)
    {
        try {
            // Generate QRCODE
            $qrcode = self::generateQRCode($param);

            // Generate QRCode Ke Base64
            $output_qr = 'qr-code/bukti-bayar/'.$qrcode;
            $get_s3_qr =  Storage::disk('public')->get($output_qr);
            $base64_qr = base64_encode($get_s3_qr);

            $src_qr = 'data:image/png;base64,' . $base64_qr;
            $param['file_qr'] = $src_qr;

            // Generate Dokumen
            $pdf = PDF::loadView('pages.dokumen-generate.format-dokumen-skr', $param, [], [
                'title'                     => "Dokumen Surat Ketetapan Retribusi",
                'format'                    => [210, 330],
                'default_font_size'         => '12',
                'default_font'              => 'Times',
                'margin_left'               => 20,
                'margin_right'              => 20,
                'margin_top'                => 10,
                'margin_bottom'             => 25,
                'margin_footer'             => 1,
            ]);

            $output_file = $param['dokumen_directory'].$param['dokumen_name'];

            Storage::disk('public')->put($output_file, $pdf->output());
            
            return $param['dokumen_name'];

        } catch (\Throwable $error) {
            Log::critical($error);
            
            return null;
        }        
    }

    public static function dokumenBarcodeInventoryAsset($param = null)
    {
        // dd($param);
        try {
            // Generate Dokumen
            $pdf = PDF::loadView('pages.dokumen-generate.barcode-inventory-asset', $param, [], [
                'title'                     => "Dokumen Barcode Inventory Asset",
                'format'                    => [210, 330],
                'default_font_size'         => '12',
                'default_font'              => 'Times',
                'margin_left'               => 5,
                'margin_right'              => 5,
                'margin_top'                => 10,
                'margin_bottom'             => 25,
                'margin_footer'             => 1,
            ]);

            $output_file = $param['dokumen_directory'].$param['dokumen_name'];

            Storage::disk('public')->put($output_file, $pdf->output());
            
            return $param['dokumen_name'];

        } catch (\Throwable $error) {
            Log::critical($error);
            
            return null;
        }        
    }

    public static function dokumenInvoicePurchases($param = null)
    {
        // dd($param['data_transaksi']);
        try {
            // Generate QRCode Ke Base64
            $output_qr = 'barcodes/purchases/qr-sale-'.$param['data_transaksi']->kode.'.png';
            $get_s3_qr =  Storage::disk('public')->get($output_qr);
            $base64_qr = base64_encode($get_s3_qr);

            $src_qr = 'data:image/png;base64,' . $base64_qr;
            $param['file_qr'] = $src_qr;

            // Generate Dokumen
            $pdf = PDF::loadView('pages.dokumen-generate.invoice-purchases-template', $param, [], [
                'title'                     => "Dokumen Invoice Purchases",
                'format'                    => [210, 330],
                'default_font_size'         => '12',
                'default_font'              => 'Times',
                'margin_left'               => 5,
                'margin_right'              => 5,
                'margin_top'                => 10,
                'margin_bottom'             => 25,
                'margin_footer'             => 0,
                'show_watermark_image'       => true,
                'watermark_image_path'       => 'images/logo_giftproject_500.png',
                'watermark_image_alpha'      => 0.15,
                'watermark_image_size'       => [120,120],
                'watermark_image_position'   => 'P',
            ]);

            $output_file = $param['dokumen_directory'].$param['dokumen_name'];

            Storage::disk('public')->put($output_file, $pdf->output());
            
            return $param['dokumen_name'];

        } catch (\Throwable $error) {
            Log::critical($error);
            
            return null;
        }        
    }

    public static function dokumenInvoicePenjualan($param = null)
    {
        // dd($param['data_transaksi']);
        try {
            // Generate QRCode Ke Base64
            $output_qr = 'barcodes/penjualan/qr-sale-'.$param['data_transaksi']->kode.'.png';
            $get_s3_qr =  Storage::disk('public')->get($output_qr);
            $base64_qr = base64_encode($get_s3_qr);

            $src_qr = 'data:image/png;base64,' . $base64_qr;
            $param['file_qr'] = $src_qr;

            // Generate Dokumen
            $pdf = PDF::loadView('pages.dokumen-generate.invoice-penjualan', $param, [], [
                'title'                     => "Dokumen Invoice Penjualan",
                'format'                    => [210, 330],
                'default_font_size'         => '12',
                'default_font'              => 'Times',
                'margin_left'               => 5,
                'margin_right'              => 5,
                'margin_top'                => 10,
                'margin_bottom'             => 25,
                'margin_footer'             => 1,
            ]);

            $output_file = $param['dokumen_directory'].$param['dokumen_name'];

            Storage::disk('public')->put($output_file, $pdf->output());
            
            return $param['dokumen_name'];

        } catch (\Throwable $error) {
            Log::critical($error);
            
            return null;
        }        
    }

    public static function dokumenInvoicePenjualanFake($param = null)
    {
        // dd($param['data_transaksi']);
        try {
            // Generate QRCode Ke Base64
            $output_qr = 'barcodes/penjualan-fake/qr-sale-'.$param['data_transaksi']->kode.'.png';
            $get_s3_qr =  Storage::disk('public')->get($output_qr);
            $base64_qr = base64_encode($get_s3_qr);

            $src_qr = 'data:image/png;base64,' . $base64_qr;
            $param['file_qr'] = $src_qr;

            // Generate Dokumen
            $pdf = PDF::loadView('pages.dokumen-generate.invoice-penjualan-fake', $param, [], [
                'title'                     => "Dokumen Invoice Penjualan",
                'format'                    => [210, 330],
                'default_font_size'         => '12',
                'default_font'              => 'Times',
                'margin_left'               => 5,
                'margin_right'              => 5,
                'margin_top'                => 10,
                'margin_bottom'             => 25,
                'margin_footer'             => 1,
            ]);

            $output_file = $param['dokumen_directory'].$param['dokumen_name'];

            Storage::disk('public')->put($output_file, $pdf->output());
            
            return $param['dokumen_name'];

        } catch (\Throwable $error) {
            Log::critical($error);
            
            return null;
        }        
    }
}