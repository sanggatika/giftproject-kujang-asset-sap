<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Carbon\Carbon;
use App\Http\Controllers\Helpers\mainController;

class devGenerateDokumen02 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dev:dev-generate-dokumen02';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '[Dev] Proses Generate Dokumen Test S3 Service 02';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        print_r("==== Proses Generte Dokumen ==== \n\n");
        $dokumen_generate = 100;
        $dokumen_sukses = 0;
        $dokumen_gagal = 0;

        for ($x = 0; $x <= $dokumen_generate; $x++) {
            $start_time = microtime(true);

            $checkTrPermohonan = [
                'tahun' => 2023,
                'nomor' => rand(1000, 9999),
                'nama_customer' => 'Giri Sanggatika',
                'alamat_customer' => 'Jl. Jenderal Ahmad Yani No.76, Nagasari, Kec. Karawang Bar., Karawang, Jawa Barat 41314',
            ];

            $rand = rand(1000,9999);
            $time = time();        
            $param = [
                // Generate Qr
                'type' => 'bukti-bayar',
                'qr_generate' => '8ed588e9-4c16-43c1-9c8d-ad811e7291a6-'.$time.'-'.$rand,
                'qr_filename' => 'qr-8ed588e9-4c16-43c1-9c8d-ad811e7291a6-'.$time.'-'.$rand.'.png',
                'qr_directory' => 'qr-code/bukti-bayar/',

                // Generate Dokumen
                'dokumen_type' => 'Surat Ketetapan Retribusi',
                'dokumen_name' => "dokument-skr-".$time.'-'.$rand."-draft.pdf",
                'dokumen_directory' => 'dokumen/surat-ketetapan-retribusi/',
                'data_permohonan' => $checkTrPermohonan,
            ];
            
            print_r("==== Start Generte Dokumen ==== \n");
            $dokumen_skr = mainController::dokumenSuratKetetapanRetribusi($param);

            if($dokumen_skr)
            {
                print_r("Status Generate : Sukses - ".$dokumen_skr." \n");
                $dokumen_sukses = ++$dokumen_sukses;
            }else{
                print_r("Status Generate : Gagal \n");
                $dokumen_gagal = ++$dokumen_gagal;
            }

            $end_time = microtime(true);
            $execution_time = ($end_time - $start_time);
            print_r("Execution time of script {$execution_time} Sec. \n");
            print_r("===== End Generte Dokumen ===== \n\n");
        } 
        
        print_r(" \n");
        print_r("== Dokumen Generate = ".$dokumen_generate." == \n");
        print_r("== Dokumen Sukses = ".$dokumen_sukses." == \n");
        print_r("== Dokumen Gagal = ".$dokumen_gagal." == \n");
    }
}
