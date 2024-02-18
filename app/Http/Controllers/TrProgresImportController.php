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
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\YourImportClass;

use Carbon\Carbon;
use App\Rules\ReCaptcha;
use App\Http\Controllers\Helpers\mainController;
use App\Imports\FormatImportRealisasiClass;

// Database
use Illuminate\Support\Facades\DB;
use App\Models\mProgramAccount;
use App\Models\mProgramDepartementCCK;
use App\Models\mProgramBagianCC;
use App\Models\mProgram;
use App\Models\tmpProgramProgresImport;

class TrProgresImportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function page_indexTrProgresImport(Request $request)
    {
        $model['route'] = 'Transaksi Program Import';

        $model['ms_program_account'] = mProgramAccount::get();
        $model['ms_program_departement_cck'] = mProgramDepartementCCK::get();
        $model['ms_program_bagian_cc'] = mProgramBagianCC::get();

        return view('pages.transaksi-progres-program-import.v_index', ['model' => $model]);
    }

    public function act_uploadTrProgresImport(Request $request)
    {
        $status = false;
        $response_code = 'RC400';
        $message = 'Data Gagal Disimpan Terjadi Gangguan..';
        $dataAPI = null;

        if ($request->ajax()) {  
            // dd($request->all());          
            $validator = Validator::make($request->all(), [
                'form_progres_program_upload_tanggal' => 'required'
            ]);

            // Ketika data kiriman tidak sesuai
            if ($validator->fails())
            {
                $response_code = "RC400";
                $message = "Form Tidak Tervalidasi Dengan Sistem";
                return $this->onResult($status, $response_code, $message, $dataAPI);
            }

            // Validasi File Upload
            if(!isset($request->form_progres_program_upload_file))
            {
                $response_code = "RC400";
                $message = "Tidak Ada File Excell Yang Di Upload";
                return $this->onResult($status, $response_code, $message, $dataAPI);
            }

            $data_file = null;
            $arrExtension = ['xls','xlt','xlsx','xlsm', 'xlsb', 'xltx', 'xltm'];
            foreach ($request->form_progres_program_upload_file as $file) {
                $filesistem_extension = $file->extension();               
                if (!in_array($filesistem_extension, $arrExtension))
                {
                    $response_code = "RC400";
                    $message = "Type File Tidak Sesuai Dengan Sistem ...";
                    return $this->onResult($status, $response_code, $message, $dataAPI);
                }

                $filesistem_size = $file->getSize();
                if($filesistem_size > 2258582)
                {
                    $response_code = "RC400";
                    $message = "Ukuran File  Tidak Sesuai Dengan Sistem ...";
                    return $this->onResult($status, $response_code, $message, $dataAPI);
                }

                $filename = 'data-progres-program-'.$request->form_progres_program_upload_tanggal."-".time();
                $filename_extension = $filename.".".$filesistem_extension;
                $filesistem = Storage::disk('public')->putFileAs('dokumen-upload/progres-program', $file, $filename_extension);
                $data_file = $filename_extension;
            }

            $data_excell = null;

            try {
                // Proses Collection Data Excell      
                $file_upload_program = 'public/dokumen-upload/progres-program/'.$data_file;
            
                $rule = new FormatImportRealisasiClass;

                $data_excell = Excel::toCollection($rule, $file_upload_program, null);  
                // dd($data_excell);              
            } catch (\Throwable $error) {
                DB::rollback();
                Log::critical($error);

                $response_code = "RC400";
                $message = "Sistem Gagal Membaca File Excell !!" .$error;
                return $this->onResult($status, $response_code, $message, $dataAPI);
            }

            $data_sukses = null;
            $data_gagal = null;

            foreach ($data_excell[0] as $index => $row)
            {
                if($index == 0)
                {
                    // format excell harus sesuai
                    // $row[0] = NO
                    // $row[1] = PROGRAM
                    // $row[4] = NILAI EAC (4)
                    // $row[7] = ACCOUNT (7)
                    // $row[12] = GL ACCOUNT
                    // $row[13] = FUND NUMBER

                    if($row[0] != 'NO' && $row[1] != 'PROGRAM' && $row[4] != 'NILAI EAC (4)' && $row[7] != 'ACCOUNT (7)' && $row[12] != 'GL ACCOUNT' && $row[13] != 'FUND NUMBER')
                    {
                        $response_code = "RC400";
                        $message = "File Master Data Excell Tidak Sesuai !!";
                        return $this->onResult($status, $response_code, $message, $dataAPI);
                    }
                }
                
                if ($index >= 1)
                {
                    // dd($row);
                    // dd($row[21]);
                    // dd(Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[21])));

                    // Cek Data Dalam Database
                    $checkExistingDataProgram =  mProgram::with('mProgramAccount', 'mProgramDepartementCCK', 'mProgramBagianCC')->where('name', $row[1])->where('fund_number', $row[13])->orWhere('fund_center', $row[0])->first();

                    if(isset($checkExistingDataProgram))
                    {
                        $checkExistingDataProgresProgramImport = tmpProgramProgresImport::where('id_program', $checkExistingDataProgram->id)->get();
                        $jml_update_import = $checkExistingDataProgresProgramImport->count() + 1;

                        $permitted_chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
                        $nomor_registrasi = "PROGRES-IMPORT-".random_int(10, 99).date('m').date('d')."-".substr(str_shuffle($permitted_chars), 0, 4)."-".time();
                        // dd($nomor_registrasi);

                        // Validasi Ketika Gagal Melakukan Transaksi Data Akan Di Rollback
                        DB::beginTransaction();

                        try {
                            // dd('test');
                            // Proses Simpan Data Kedalam Database      
                            $AddTmpProgresProgramImport = new tmpProgramProgresImport();

                            $AddTmpProgresProgramImport->uuid =  (string) Str::uuid();
                            $AddTmpProgresProgramImport->code =  $nomor_registrasi;
                            $AddTmpProgresProgramImport->id_program =  $checkExistingDataProgram->id;
                            $AddTmpProgresProgramImport->name_program =  $checkExistingDataProgram->name;
                            $AddTmpProgresProgramImport->id_program_account =  $checkExistingDataProgram->id_program_account;
                            $AddTmpProgresProgramImport->name_program_account =  $checkExistingDataProgram->name_program_account;
                            $AddTmpProgresProgramImport->id_program_departement_cck =  $checkExistingDataProgram->id_program_departement_cck;
                            $AddTmpProgresProgramImport->name_program_departement_cck =  $checkExistingDataProgram->name_program_departement_cck;
                            $AddTmpProgresProgramImport->id_program_bagian_cc =  $checkExistingDataProgram->id_program_bagian_cc;
                            $AddTmpProgresProgramImport->name_program_bagian_cc =  $checkExistingDataProgram->name_program_bagian_cc;
                            
                            $AddTmpProgresProgramImport->status_progres =  $row[2];
                            $AddTmpProgresProgramImport->type_pengadaan =  $row[16];
                            $AddTmpProgresProgramImport->lokasi_pengadaan =  $row[18];
                            $AddTmpProgresProgramImport->nominal_anggaran =   $checkExistingDataProgram->nominal;
                            $AddTmpProgresProgramImport->nominal_pengajuan =  $row[5];
                            $sisa_anggaran = $checkExistingDataProgram->nominal - (int)$row[5];
                            $AddTmpProgresProgramImport->nominal_sisa =  $sisa_anggaran;

                            $AddTmpProgresProgramImport->no_mir_sr =  $row[14];
                            $AddTmpProgresProgramImport->no_pr =  $row[15];
                            $AddTmpProgresProgramImport->no_po =  $row[17];
                            // $AddTmpProgresProgramImport->no_gr =  $row[2];

                            $date_mir_sr = null;
                            if($row[19] != null)
                            {   
                                $date_mir_sr = Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[19]));
                            }
                            $AddTmpProgresProgramImport->date_mir_sr =  $date_mir_sr;

                            $date_pr = null;
                            if($row[20] != null)
                            {   
                                $date_pr = Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[20]));
                            }
                            $AddTmpProgresProgramImport->date_pr = $date_pr;

                            $date_po = null;
                            if($row[21] != null)
                            {   
                                // $date_po = Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[21]));
                                try {
                                    $date_po = Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[21]));
                                } catch (\Throwable $error) {
                                    $date_po = Carbon::now();
                                }
                            }
                            $AddTmpProgresProgramImport->date_po = $date_po;

                            $date_po_estimasi = null;
                            if($row[22] != null)
                            {   
                                //
                                try {
                                    $date_po_estimasi = Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[22]));
                                } catch (\Throwable $error) {
                                    $date_po_estimasi = Carbon::now();
                                }
                            }
                            $AddTmpProgresProgramImport->date_po_estimasi = $date_po_estimasi;

                            $date_gr = null;
                            if($row[23] != null)
                            {   
                                $date_gr = Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[23]));
                            }
                            $AddTmpProgresProgramImport->date_gr = $date_gr;
                            
                            $AddTmpProgresProgramImport->count_import =  $jml_update_import;
                            $AddTmpProgresProgramImport->status =  1;
                            $AddTmpProgresProgramImport->created_at = Carbon::now();
                            $AddTmpProgresProgramImport->updated_at = Carbon::now();
                            $AddTmpProgresProgramImport->created_by = Auth::user()->id;

                            $AddTmpProgresProgramImport->save();

                            DB::commit();  
                            
                            // dd('test2');
                        } catch (\Throwable $error) {
                            DB::rollback();
                            Log::critical($error);
                        }
                    }
                }                
            }            

            $status = true;
            $response_code = 'RC200';
            $message = 'Data Berhasil Di Simpan, Terimakasih';           

            return $this->onResult($status, $response_code, $message, $dataAPI); 

        }
        return $this->onResult($status, $response_code, $message, $dataAPI);
    }

    public function get_datatableTrProgresImport(Request $request)
    {
        $status = false;
        $response_code = 'RC400';
        $message = 'Data Gagal Disimpan Terjadi Gangguan..';
        $dataAPI = null;
        
        if ($request->ajax()) {
            
            $form_filter_program = $request->form_filter_program;
            $form_filter_program_account = $request->form_filter_program_account;
            $form_filter_program_departement = $request->form_filter_program_departement;
            $form_filter_program_bagian = $request->form_filter_program_bagian;
            $form_filter_program_kriteria = $request->form_filter_program_kriteria;
            $form_filter_program_direktorat = $request->form_filter_program_direktorat;
            $form_filter_program_statusprogres = $request->form_filter_program_statusprogres;
            $form_filter_program_priority = $request->form_filter_program_priority;

            $dataMsProgram = mProgram::with('tmpProgramProgresImportLast')->whereNotNull('uuid')->where('status', 1);

            $msProgram = $dataMsProgram->get();

            $jumlahMsProgram = $msProgram->count();
            $totalMsProgramNominal = $msProgram->sum('nominal');

            // Filter Data
            if($form_filter_program != "")
            {
                $dataMsProgram->where('name', 'like', '%'.$form_filter_program.'%')->orWhere('fund_number',$form_filter_program);
            }

            if($form_filter_program_account != "-")
            {
                $checkExistingDataProgramAccount =  mProgramAccount::where('uuid', $request->form_filter_program_account)->first();
                $dataMsProgram->where('id_program_account', $checkExistingDataProgramAccount->id);
            }

            if($form_filter_program_departement != "-")
            {
                $checkExistingDataProgramDepartement =  mProgramDepartementCCK::where('uuid', $request->form_filter_program_departement)->first();
                $dataMsProgram->where('id_program_departement_cck', $checkExistingDataProgramDepartement->id);
            }

            if($form_filter_program_bagian != "-")
            {
                $checkExistingDataProgramBagian =  mProgramBagianCC::where('uuid', $request->form_filter_program_bagian)->first();
                $dataMsProgram->where('id_program_bagian_cc', $checkExistingDataProgramBagian->id);
            }

            if($form_filter_program_kriteria != "-")
            {
                $dataMsProgram->where('kriteria_pengadaan', $request->form_filter_program_kriteria);
            }

            if($form_filter_program_direktorat != "-")
            {
                $dataMsProgram->where('direktorat', $request->form_filter_program_direktorat);
            }

            if($form_filter_program_statusprogres != "-")
            {
                $status_progres = $form_filter_program_statusprogres;
                
                $dataMsProgram->whereHas('tmpProgramProgresImportLast', function ($query) use ($status_progres) {
                    $query->where('status_progres', $status_progres);
                });
            }

            if($form_filter_program_priority != "-")
            {
                $dataMsProgram->where('priority', $request->form_filter_program_priority);
            }

            $data = $dataMsProgram->get();

            $jumlahFilterMsProgram = $data->count();
            $totalFilterMsProgramNominal = $data->sum('nominal');

            $jumlahFilterMsProgramSingleYear = $data->where('kriteria_pengadaan', 'Singleyear')->count();
            $totalFilterMsProgramNominalSingleYear = $data->where('kriteria_pengadaan', 'Singleyear')->sum('nominal');
            $jumlahFilterMsProgramMultiYear = $data->where('kriteria_pengadaan', 'Multiyears 24-25')->count();
            $totalFilterMsProgramNominalMultiYear = $data->where('kriteria_pengadaan', 'Multiyears 24-25')->sum('nominal');

            // GL Account
            // GL Account Pabrik
            $dataMsProgramPabrik = $data->where('id_program_account', 4);
            $jumlahFilterMsProgramAccountPabrik = $dataMsProgramPabrik->count();
            $totalFilterMsProgramNominalAccountPabrik = $dataMsProgramPabrik->sum('nominal');
            // Filter Status User
            $dataMsProgramPabrikUSER = $dataMsProgramPabrik->filter(function ($program) {
                return optional($program->tmpProgramProgresImportLast)->status_progres == 'USER';
            });
            $jumlahFilterMsProgramAccountPabrikUser = $dataMsProgramPabrikUSER->count();
            $totalFilterMsProgramNominalAccountPabrikUser = $dataMsProgramPabrikUSER->sum('nominal');
            // Filter Status MIR
            $dataMsProgramPabrikMIR = $dataMsProgramPabrik->filter(function ($program) {
                return optional($program->tmpProgramProgresImportLast)->status_progres == 'MIR';
            });
            $jumlahFilterMsProgramAccountPabrikMIR = $dataMsProgramPabrikMIR->count();
            $totalFilterMsProgramNominalAccountPabrikMIR = $dataMsProgramPabrikMIR->sum('nominal');
            // Filter Status SR
            $dataMsProgramPabrikSR = $dataMsProgramPabrik->filter(function ($program) {
                return optional($program->tmpProgramProgresImportLast)->status_progres == 'SR';
            });
            $jumlahFilterMsProgramAccountPabrikSR = $dataMsProgramPabrikSR->count();
            $totalFilterMsProgramNominalAccountPabrikSR = $dataMsProgramPabrikSR->sum('nominal');
            // Filter Status PR
            $dataMsProgramPabrikPR = $dataMsProgramPabrik->filter(function ($program) {
                return optional($program->tmpProgramProgresImportLast)->status_progres == 'PR';
            });
            $jumlahFilterMsProgramAccountPabrikPR = $dataMsProgramPabrikPR->count();
            $totalFilterMsProgramNominalAccountPabrikPR =  $dataMsProgramPabrikPR->sum(function ($program) {
                return optional($program->tmpProgramProgresImportLast)->nominal_pengajuan ?? 0;
            });
            // Filter Status PO
            $dataMsProgramPabrikPO = $dataMsProgramPabrik->filter(function ($program) {
                return optional($program->tmpProgramProgresImportLast)->status_progres == 'PO';
            });
            $jumlahFilterMsProgramAccountPabrikPO = $dataMsProgramPabrikPO->count();
            $totalFilterMsProgramNominalAccountPabrikPO =  $dataMsProgramPabrikPO->sum(function ($program) {
                return optional($program->tmpProgramProgresImportLast)->nominal_pengajuan ?? 0;
            });
            // Filter Status GR
            $dataMsProgramPabrikGR = $dataMsProgramPabrik->filter(function ($program) {
                return optional($program->tmpProgramProgresImportLast)->status_progres == 'GR';
            });
            $jumlahFilterMsProgramAccountPabrikGR = $dataMsProgramPabrikGR->count();
            $totalFilterMsProgramNominalAccountPabrikGR =  $dataMsProgramPabrikGR->sum(function ($program) {
                return optional($program->tmpProgramProgresImportLast)->nominal_pengajuan ?? 0;
            });

            // GL Account A2B
            $dataMsProgramA2B = $data->where('id_program_account', 1);
            $jumlahFilterMsProgramAccountA2B = $dataMsProgramA2B->count();
            $totalFilterMsProgramNominalAccountA2B = $dataMsProgramA2B->sum('nominal');
            // Filter Status User
            $dataMsProgramA2BUSER = $dataMsProgramA2B->filter(function ($program) {
                return optional($program->tmpProgramProgresImportLast)->status_progres == 'USER';
            });
            $jumlahFilterMsProgramAccountA2BUser = $dataMsProgramA2BUSER->count();
            $totalFilterMsProgramNominalAccountA2BUser = $dataMsProgramA2BUSER->sum('nominal');
            // Filter Status MIR
            $dataMsProgramA2BMIR = $dataMsProgramA2B->filter(function ($program) {
                return optional($program->tmpProgramProgresImportLast)->status_progres == 'MIR';
            });
            $jumlahFilterMsProgramAccountA2BMIR = $dataMsProgramA2BMIR->count();
            $totalFilterMsProgramNominalAccountA2BMIR = $dataMsProgramA2BMIR->sum('nominal');
            // Filter Status SR
            $dataMsProgramA2BSR = $dataMsProgramA2B->filter(function ($program) {
                return optional($program->tmpProgramProgresImportLast)->status_progres == 'SR';
            });
            $jumlahFilterMsProgramAccountA2BSR = $dataMsProgramA2BSR->count();
            $totalFilterMsProgramNominalAccountA2BSR = $dataMsProgramA2BSR->sum('nominal');
            // Filter Status PR
            $dataMsProgramA2BPR = $dataMsProgramA2B->filter(function ($program) {
                return optional($program->tmpProgramProgresImportLast)->status_progres == 'PR';
            });
            $jumlahFilterMsProgramAccountA2BPR = $dataMsProgramA2BPR->count();
            $totalFilterMsProgramNominalAccountA2BPR = $dataMsProgramA2BPR->sum(function ($program) {
                return optional($program->tmpProgramProgresImportLast)->nominal_pengajuan ?? 0;
            });
            // Filter Status PO
            $dataMsProgramA2BPO = $dataMsProgramA2B->filter(function ($program) {
                return optional($program->tmpProgramProgresImportLast)->status_progres == 'PO';
            });
            $jumlahFilterMsProgramAccountA2BPO = $dataMsProgramA2BPO->count();
            $totalFilterMsProgramNominalAccountA2BPO = $dataMsProgramA2BPO->sum(function ($program) {
                return optional($program->tmpProgramProgresImportLast)->nominal_pengajuan ?? 0;
            });
            // Filter Status GR
            $dataMsProgramA2BGR = $dataMsProgramA2B->filter(function ($program) {
                return optional($program->tmpProgramProgresImportLast)->status_progres == 'GR';
            });
            $jumlahFilterMsProgramAccountA2BGR = $dataMsProgramA2BGR->count();
            $totalFilterMsProgramNominalAccountA2BGR = $dataMsProgramA2BGR->sum(function ($program) {
                return optional($program->tmpProgramProgresImportLast)->nominal_pengajuan ?? 0;
            });

            // GL Account Peralatan
            $dataMsProgramPeralatan = $data->where('id_program_account', 5);
            $jumlahFilterMsProgramAccountPeralatan = $dataMsProgramPeralatan->count();
            $totalFilterMsProgramNominalAccountPeralatan = $dataMsProgramPeralatan->sum('nominal');
            // Filter Status User
            $dataMsProgramPeralatanUSER = $dataMsProgramPeralatan->filter(function ($program) {
                return optional($program->tmpProgramProgresImportLast)->status_progres == 'USER';
            });
            $jumlahFilterMsProgramAccountPeralatanUser = $dataMsProgramPeralatanUSER->count();
            $totalFilterMsProgramNominalAccountPeralatanUser = $dataMsProgramPeralatanUSER->sum('nominal');
            // Filter Status MIR
            $dataMsProgramPeralatanMIR = $dataMsProgramPeralatan->filter(function ($program) {
                return optional($program->tmpProgramProgresImportLast)->status_progres == 'MIR';
            });
            $jumlahFilterMsProgramAccountPeralatanMIR = $dataMsProgramPeralatanMIR->count();
            $totalFilterMsProgramNominalAccountPeralatanMIR = $dataMsProgramPeralatanMIR->sum('nominal');
            // Filter Status SR
            $dataMsProgramPeralatanSR = $dataMsProgramPeralatan->filter(function ($program) {
                return optional($program->tmpProgramProgresImportLast)->status_progres == 'SR';
            });
            $jumlahFilterMsProgramAccountPeralatanSR = $dataMsProgramPeralatanSR->count();
            $totalFilterMsProgramNominalAccountPeralatanSR = $dataMsProgramPeralatanSR->sum('nominal');
            // Filter Status PR
            $dataMsProgramPeralatanPR = $dataMsProgramPeralatan->filter(function ($program) {
                return optional($program->tmpProgramProgresImportLast)->status_progres == 'PR';
            });
            $jumlahFilterMsProgramAccountPeralatanPR = $dataMsProgramPeralatanPR->count();
            $totalFilterMsProgramNominalAccountPeralatanPR = $dataMsProgramPeralatanPR->sum(function ($program) {
                return optional($program->tmpProgramProgresImportLast)->nominal_pengajuan ?? 0;
            });
            // Filter Status PO
            $dataMsProgramPeralatanPO = $dataMsProgramPeralatan->filter(function ($program) {
                return optional($program->tmpProgramProgresImportLast)->status_progres == 'PO';
            });
            $jumlahFilterMsProgramAccountPeralatanPO = $dataMsProgramPeralatanPO->count();
            $totalFilterMsProgramNominalAccountPeralatanPO = $dataMsProgramPeralatanPO->sum(function ($program) {
                return optional($program->tmpProgramProgresImportLast)->nominal_pengajuan ?? 0;
            });
            // Filter Status GR
            $dataMsProgramPeralatanGR = $dataMsProgramPeralatan->filter(function ($program) {
                return optional($program->tmpProgramProgresImportLast)->status_progres == 'GR';
            });
            $jumlahFilterMsProgramAccountPeralatanGR = $dataMsProgramPeralatanGR->count();
            $totalFilterMsProgramNominalAccountPeralatanGR = $dataMsProgramPeralatanGR->sum(function ($program) {
                return optional($program->tmpProgramProgresImportLast)->nominal_pengajuan ?? 0;
            });

            // GL Account Bangunan
            $dataMsProgramBangunan = $data->where('id_program_account', 3);
            $jumlahFilterMsProgramAccountBangunan = $dataMsProgramBangunan->count();
            $totalFilterMsProgramNominalAccountBangunan = $dataMsProgramBangunan->sum('nominal');
            // Filter Status User
            $dataMsProgramBangunanUSER = $dataMsProgramBangunan->filter(function ($program) {
                return optional($program->tmpProgramProgresImportLast)->status_progres == 'USER';
            });
            $jumlahFilterMsProgramAccountBangunanUser = $dataMsProgramBangunanUSER->count();
            $totalFilterMsProgramNominalAccountBangunanUser = $dataMsProgramBangunanUSER->sum('nominal');
            // Filter Status MIR
            $dataMsProgramBangunanMIR = $dataMsProgramBangunan->filter(function ($program) {
                return optional($program->tmpProgramProgresImportLast)->status_progres == 'MIR';
            });
            $jumlahFilterMsProgramAccountBangunanMIR = $dataMsProgramBangunanMIR->count();
            $totalFilterMsProgramNominalAccountBangunanMIR = $dataMsProgramBangunanMIR->sum('nominal');
            // Filter Status SR
            $dataMsProgramBangunanSR = $dataMsProgramBangunan->filter(function ($program) {
                return optional($program->tmpProgramProgresImportLast)->status_progres == 'SR';
            });
            $jumlahFilterMsProgramAccountBangunanSR = $dataMsProgramBangunanSR->count();
            $totalFilterMsProgramNominalAccountBangunanSR = $dataMsProgramBangunanSR->sum('nominal');
            // Filter Status PR
            $dataMsProgramBangunanPR = $dataMsProgramBangunan->filter(function ($program) {
                return optional($program->tmpProgramProgresImportLast)->status_progres == 'PR';
            });
            $jumlahFilterMsProgramAccountBangunanPR = $dataMsProgramBangunanPR->count();
            $totalFilterMsProgramNominalAccountBangunanPR = $dataMsProgramBangunanPR->sum(function ($program) {
                return optional($program->tmpProgramProgresImportLast)->nominal_pengajuan ?? 0;
            });
            // Filter Status PO
            $dataMsProgramBangunanPO = $dataMsProgramBangunan->filter(function ($program) {
                return optional($program->tmpProgramProgresImportLast)->status_progres == 'PO';
            });
            $jumlahFilterMsProgramAccountBangunanPO = $dataMsProgramBangunanPO->count();
            // $totalFilterMsProgramNominalAccountBangunanPO = $dataMsProgramBangunanPO->sum(function ($program) {
            //     return optional($program->tmpProgramProgresImportLast)->nominal_pengajuan ?? 0;
            // });
            $totalFilterMsProgramNominalAccountBangunanPO = $dataMsProgramBangunanPO->sum('nominal');
            // dd($totalFilterMsProgramNominalAccountBangunanPO);
            // Filter Status GR
            $dataMsProgramBangunanGR = $dataMsProgramBangunan->filter(function ($program) {
                return optional($program->tmpProgramProgresImportLast)->status_progres == 'GR';
            });
            $jumlahFilterMsProgramAccountBangunanGR = $dataMsProgramBangunanGR->count();
            $totalFilterMsProgramNominalAccountBangunanGR = $dataMsProgramBangunanGR->sum(function ($program) {
                return optional($program->tmpProgramProgresImportLast)->nominal_pengajuan ?? 0;
            });

            // GL Account Aset Tak Berwujud
            $dataMsProgramAsetTBWJD = $data->where('id_program_account', 2);
            $jumlahFilterMsProgramAccountAsetTBWJD = $dataMsProgramAsetTBWJD->count();
            $totalFilterMsProgramNominalAccountAsetTBWJD = $dataMsProgramAsetTBWJD->sum('nominal');
            // Filter Status User
            $dataMsProgramAsetTBWJDUSER = $dataMsProgramAsetTBWJD->filter(function ($program) {
                return optional($program->tmpProgramProgresImportLast)->status_progres == 'USER';
            });
            $jumlahFilterMsProgramAccountAsetTBWJDUser = $dataMsProgramAsetTBWJDUSER->count();
            $totalFilterMsProgramNominalAccountAsetTBWJDUser = $dataMsProgramAsetTBWJDUSER->sum('nominal');
            // Filter Status MIR
            $dataMsProgramAsetTBWJDMIR = $dataMsProgramAsetTBWJD->filter(function ($program) {
                return optional($program->tmpProgramProgresImportLast)->status_progres == 'MIR';
            });
            $jumlahFilterMsProgramAccountAsetTBWJDMIR = $dataMsProgramAsetTBWJDMIR->count();
            $totalFilterMsProgramNominalAccountAsetTBWJDMIR = $dataMsProgramAsetTBWJDMIR->sum('nominal');
            // Filter Status SR
            $dataMsProgramAsetTBWJDSR = $dataMsProgramAsetTBWJD->filter(function ($program) {
                return optional($program->tmpProgramProgresImportLast)->status_progres == 'SR';
            });
            $jumlahFilterMsProgramAccountAsetTBWJDSR = $dataMsProgramAsetTBWJDSR->count();
            $totalFilterMsProgramNominalAccountAsetTBWJDSR = $dataMsProgramAsetTBWJDSR->sum('nominal');
            // Filter Status PR
            $dataMsProgramAsetTBWJDPR = $dataMsProgramAsetTBWJD->filter(function ($program) {
                return optional($program->tmpProgramProgresImportLast)->status_progres == 'PR';
            });
            $jumlahFilterMsProgramAccountAsetTBWJDPR = $dataMsProgramAsetTBWJDPR->count();
            $totalFilterMsProgramNominalAccountAsetTBWJDPR = $dataMsProgramAsetTBWJDPR->sum(function ($program) {
                return optional($program->tmpProgramProgresImportLast)->nominal_pengajuan ?? 0;
            });
            // Filter Status PO
            $dataMsProgramAsetTBWJDPO = $dataMsProgramAsetTBWJD->filter(function ($program) {
                return optional($program->tmpProgramProgresImportLast)->status_progres == 'PO';
            });
            $jumlahFilterMsProgramAccountAsetTBWJDPO = $dataMsProgramAsetTBWJDPO->count();
            // $totalFilterMsProgramNominalAccountAsetTBWJDPO = $dataMsProgramAsetTBWJDPO->sum(function ($program) {
            //     return optional($program->tmpProgramProgresImportLast)->nominal_pengajuan ?? 0;
            // });
            $totalFilterMsProgramNominalAccountAsetTBWJDPO = $dataMsProgramAsetTBWJDPO->sum('nominal');
            // Filter Status GR
            $dataMsProgramAsetTBWJDGR = $dataMsProgramAsetTBWJD->filter(function ($program) {
                return optional($program->tmpProgramProgresImportLast)->status_progres == 'GR';
            });
            $jumlahFilterMsProgramAccountAsetTBWJDGR = $dataMsProgramAsetTBWJDGR->count();
            $totalFilterMsProgramNominalAccountAsetTBWJDGR = $dataMsProgramAsetTBWJDGR->sum(function ($program) {
                return optional($program->tmpProgramProgresImportLast)->nominal_pengajuan ?? 0;
            });

            // GL Account SCP
            $dataMsProgramSCP = $data->where('id_program_account', 6);
            $jumlahFilterMsProgramAccountSCP = $dataMsProgramSCP->count();
            $totalFilterMsProgramNominalAccountSCP = $dataMsProgramSCP->sum('nominal');
            // Filter Status User
            $dataMsProgramSCPUSER = $dataMsProgramSCP->filter(function ($program) {
                return optional($program->tmpProgramProgresImportLast)->status_progres == 'USER';
            });
            $jumlahFilterMsProgramAccountSCPUser = $dataMsProgramSCPUSER->count();
            $totalFilterMsProgramNominalAccountSCPUser = $dataMsProgramSCPUSER->sum('nominal');
            // Filter Status MIR
            $dataMsProgramSCPMIR = $dataMsProgramSCP->filter(function ($program) {
                return optional($program->tmpProgramProgresImportLast)->status_progres == 'MIR';
            });
            $jumlahFilterMsProgramAccountSCPMIR = $dataMsProgramSCPMIR->count();
            $totalFilterMsProgramNominalAccountSCPMIR = $dataMsProgramSCPMIR->sum('nominal');
            // Filter Status SR
            $dataMsProgramSCPSR = $dataMsProgramSCP->filter(function ($program) {
                return optional($program->tmpProgramProgresImportLast)->status_progres == 'SR';
            });
            $jumlahFilterMsProgramAccountSCPSR = $dataMsProgramSCPSR->count();
            $totalFilterMsProgramNominalAccountSCPSR = $dataMsProgramSCPSR->sum('nominal');
            // Filter Status PR
            $dataMsProgramSCPPR = $dataMsProgramSCP->filter(function ($program) {
                return optional($program->tmpProgramProgresImportLast)->status_progres == 'PR';
            });
            $jumlahFilterMsProgramAccountSCPPR = $dataMsProgramSCPPR->count();
            $totalFilterMsProgramNominalAccountSCPPR = $dataMsProgramSCPPR->sum(function ($program) {
                return optional($program->tmpProgramProgresImportLast)->nominal_pengajuan ?? 0;
            });
            // Filter Status PO
            $dataMsProgramSCPPO = $dataMsProgramSCP->filter(function ($program) {
                return optional($program->tmpProgramProgresImportLast)->status_progres == 'PO';
            });
            $jumlahFilterMsProgramAccountSCPPO = $dataMsProgramSCPPO->count();
            $totalFilterMsProgramNominalAccountSCPPO = $dataMsProgramSCPPO->sum(function ($program) {
                return optional($program->tmpProgramProgresImportLast)->nominal_pengajuan ?? 0;
            });
            // $totalFilterMsProgramNominalAccountSCPPO = $dataMsProgramSCPPO->sum('nominal');
            // Filter Status GR
            $dataMsProgramSCPGR = $dataMsProgramSCP->filter(function ($program) {
                return optional($program->tmpProgramProgresImportLast)->status_progres == 'GR';
            });
            $jumlahFilterMsProgramAccountSCPGR = $dataMsProgramSCPGR->count();
            $totalFilterMsProgramNominalAccountSCPGR = $dataMsProgramSCPGR->sum(function ($program) {
                return optional($program->tmpProgramProgresImportLast)->nominal_pengajuan ?? 0;
            });

            // Total GL Account
            $jumlahFilterMsProgramAccount = $jumlahFilterMsProgramAccountPabrik + $jumlahFilterMsProgramAccountA2B + $jumlahFilterMsProgramAccountPeralatan + $jumlahFilterMsProgramAccountBangunan + $jumlahFilterMsProgramAccountAsetTBWJD + $jumlahFilterMsProgramAccountSCP;
            
            $totalFilterMsProgramNominalAccount = $totalFilterMsProgramNominalAccountPabrik + $totalFilterMsProgramNominalAccountA2B + $totalFilterMsProgramNominalAccountPeralatan + $totalFilterMsProgramNominalAccountBangunan + $totalFilterMsProgramNominalAccountAsetTBWJD + $totalFilterMsProgramNominalAccountSCP;

            $jumlahFilterMsProgramAccountUser = $jumlahFilterMsProgramAccountPabrikUser + $jumlahFilterMsProgramAccountA2BUser + $jumlahFilterMsProgramAccountPeralatanUser + + $jumlahFilterMsProgramAccountBangunanUser + $jumlahFilterMsProgramAccountAsetTBWJDUser + $jumlahFilterMsProgramAccountSCPUser;
            $totalFilterMsProgramNominalAccountUser = $totalFilterMsProgramNominalAccountPabrikUser + $totalFilterMsProgramNominalAccountA2BUser + $totalFilterMsProgramNominalAccountPeralatanUser + $totalFilterMsProgramNominalAccountBangunanUser + $totalFilterMsProgramNominalAccountAsetTBWJDUser + $totalFilterMsProgramNominalAccountSCPUser;

            $jumlahFilterMsProgramAccountMIR = $jumlahFilterMsProgramAccountPabrikMIR + $jumlahFilterMsProgramAccountA2BMIR + $jumlahFilterMsProgramAccountPeralatanMIR + $jumlahFilterMsProgramAccountBangunanMIR + $jumlahFilterMsProgramAccountAsetTBWJDMIR + $jumlahFilterMsProgramAccountSCPMIR;
            $totalFilterMsProgramNominalAccountMIR = $totalFilterMsProgramNominalAccountPabrikMIR + $totalFilterMsProgramNominalAccountA2BMIR + $totalFilterMsProgramNominalAccountPeralatanMIR + $totalFilterMsProgramNominalAccountBangunanMIR + $totalFilterMsProgramNominalAccountAsetTBWJDMIR + $totalFilterMsProgramNominalAccountSCPMIR;

            $jumlahFilterMsProgramAccountSR = $jumlahFilterMsProgramAccountPabrikSR + $jumlahFilterMsProgramAccountA2BSR + $jumlahFilterMsProgramAccountPeralatanSR + $jumlahFilterMsProgramAccountBangunanSR + $jumlahFilterMsProgramAccountAsetTBWJDSR + $jumlahFilterMsProgramAccountSCPSR;
            $totalFilterMsProgramNominalAccountSR = $totalFilterMsProgramNominalAccountPabrikSR + $totalFilterMsProgramNominalAccountA2BSR + $totalFilterMsProgramNominalAccountPeralatanSR + $totalFilterMsProgramNominalAccountBangunanSR + $totalFilterMsProgramNominalAccountAsetTBWJDSR + $totalFilterMsProgramNominalAccountSCPSR;

            $jumlahFilterMsProgramAccountPR = $jumlahFilterMsProgramAccountPabrikPR + $jumlahFilterMsProgramAccountA2BPR + $jumlahFilterMsProgramAccountPeralatanPR + $jumlahFilterMsProgramAccountBangunanPR + $jumlahFilterMsProgramAccountAsetTBWJDPR + $jumlahFilterMsProgramAccountSCPPR;
            $totalFilterMsProgramNominalAccountPR = $totalFilterMsProgramNominalAccountPabrikPR + $totalFilterMsProgramNominalAccountA2BPR + $totalFilterMsProgramNominalAccountPeralatanPR + $totalFilterMsProgramNominalAccountBangunanPR + $totalFilterMsProgramNominalAccountAsetTBWJDPR + $totalFilterMsProgramNominalAccountSCPPR;

            $jumlahFilterMsProgramAccountPO = $jumlahFilterMsProgramAccountPabrikPO + $jumlahFilterMsProgramAccountA2BPO + $jumlahFilterMsProgramAccountPeralatanPO + $jumlahFilterMsProgramAccountBangunanPO + $jumlahFilterMsProgramAccountAsetTBWJDPO + $jumlahFilterMsProgramAccountSCPPO;
            $totalFilterMsProgramNominalAccountPO = $totalFilterMsProgramNominalAccountPabrikPO + $totalFilterMsProgramNominalAccountA2BPO + $totalFilterMsProgramNominalAccountPeralatanPO + $totalFilterMsProgramNominalAccountBangunanPO + $totalFilterMsProgramNominalAccountAsetTBWJDPO + $totalFilterMsProgramNominalAccountSCPPO;

            $jumlahFilterMsProgramAccountGR = $jumlahFilterMsProgramAccountPabrikGR + $jumlahFilterMsProgramAccountA2BGR + $jumlahFilterMsProgramAccountPeralatanGR + $jumlahFilterMsProgramAccountBangunanGR + $jumlahFilterMsProgramAccountAsetTBWJDGR + $jumlahFilterMsProgramAccountSCPGR;
            $totalFilterMsProgramNominalAccountGR = $totalFilterMsProgramNominalAccountPabrikGR + $totalFilterMsProgramNominalAccountA2BGR + $totalFilterMsProgramNominalAccountPeralatanGR + $totalFilterMsProgramNominalAccountBangunanGR + $totalFilterMsProgramNominalAccountAsetTBWJDGR + $totalFilterMsProgramNominalAccountSCPGR;

            return DataTables::of($data)
            ->with('jumlahMsProgram', number_format($jumlahMsProgram,0,',','.'))
            ->with('totalMsProgramNominal', number_format($totalMsProgramNominal,0,',','.'))
            ->with('jumlahFilterMsProgram', number_format($jumlahFilterMsProgram,0,',','.'))
            ->with('totalFilterMsProgramNominal', number_format($totalFilterMsProgramNominal,0,',','.'))
            ->with('jumlahFilterMsProgramSingleYear', number_format($jumlahFilterMsProgramSingleYear,0,',','.'))
            ->with('totalFilterMsProgramNominalSingleYear', number_format($totalFilterMsProgramNominalSingleYear,0,',','.'))
            ->with('jumlahFilterMsProgramMultiYear', number_format($jumlahFilterMsProgramMultiYear,0,',','.'))
            ->with('totalFilterMsProgramNominalMultiYear', number_format($totalFilterMsProgramNominalMultiYear,0,',','.'))
            
            ->with('jumlahFilterMsProgramAccountPabrik', number_format($jumlahFilterMsProgramAccountPabrik,0,',','.'))
            ->with('totalFilterMsProgramNominalAccountPabrik', number_format($totalFilterMsProgramNominalAccountPabrik,0,',','.'))
            ->with('jumlahFilterMsProgramAccountPabrikUser', number_format($jumlahFilterMsProgramAccountPabrikUser,0,',','.'))
            ->with('totalFilterMsProgramNominalAccountPabrikUser', number_format($totalFilterMsProgramNominalAccountPabrikUser,0,',','.'))
            ->with('jumlahFilterMsProgramAccountPabrikMIR', number_format($jumlahFilterMsProgramAccountPabrikMIR,0,',','.'))
            ->with('totalFilterMsProgramNominalAccountPabrikMIR', number_format($totalFilterMsProgramNominalAccountPabrikMIR,0,',','.'))
            ->with('jumlahFilterMsProgramAccountPabrikSR', number_format($jumlahFilterMsProgramAccountPabrikSR,0,',','.'))
            ->with('totalFilterMsProgramNominalAccountPabrikSR', number_format($totalFilterMsProgramNominalAccountPabrikSR,0,',','.'))
            ->with('jumlahFilterMsProgramAccountPabrikPR', number_format($jumlahFilterMsProgramAccountPabrikPR,0,',','.'))
            ->with('totalFilterMsProgramNominalAccountPabrikPR', number_format($totalFilterMsProgramNominalAccountPabrikPR,0,',','.'))
            ->with('jumlahFilterMsProgramAccountPabrikPO', number_format($jumlahFilterMsProgramAccountPabrikPO,0,',','.'))
            ->with('totalFilterMsProgramNominalAccountPabrikPO', number_format($totalFilterMsProgramNominalAccountPabrikPO,0,',','.'))
            ->with('jumlahFilterMsProgramAccountPabrikGR', number_format($jumlahFilterMsProgramAccountPabrikGR,0,',','.'))
            ->with('totalFilterMsProgramNominalAccountPabrikGR', number_format($totalFilterMsProgramNominalAccountPabrikGR,0,',','.'))
            
            ->with('jumlahFilterMsProgramAccountA2B', number_format($jumlahFilterMsProgramAccountA2B,0,',','.'))
            ->with('totalFilterMsProgramNominalAccountA2B', number_format($totalFilterMsProgramNominalAccountA2B,0,',','.'))
            ->with('jumlahFilterMsProgramAccountA2BUser', number_format($jumlahFilterMsProgramAccountA2BUser,0,',','.'))
            ->with('totalFilterMsProgramNominalAccountA2BUser', number_format($totalFilterMsProgramNominalAccountA2BUser,0,',','.'))
            ->with('jumlahFilterMsProgramAccountA2BMIR', number_format($jumlahFilterMsProgramAccountA2BMIR,0,',','.'))
            ->with('totalFilterMsProgramNominalAccountA2BMIR', number_format($totalFilterMsProgramNominalAccountA2BMIR,0,',','.'))
            ->with('jumlahFilterMsProgramAccountA2BSR', number_format($jumlahFilterMsProgramAccountA2BSR,0,',','.'))
            ->with('totalFilterMsProgramNominalAccountA2BSR', number_format($totalFilterMsProgramNominalAccountA2BSR,0,',','.'))
            ->with('jumlahFilterMsProgramAccountA2BPR', number_format($jumlahFilterMsProgramAccountA2BPR,0,',','.'))
            ->with('totalFilterMsProgramNominalAccountA2BPR', number_format($totalFilterMsProgramNominalAccountA2BPR,0,',','.'))
            ->with('jumlahFilterMsProgramAccountA2BPO', number_format($jumlahFilterMsProgramAccountA2BPO,0,',','.'))
            ->with('totalFilterMsProgramNominalAccountA2BPO', number_format($totalFilterMsProgramNominalAccountA2BPO,0,',','.'))
            ->with('jumlahFilterMsProgramAccountA2BGR', number_format($jumlahFilterMsProgramAccountA2BGR,0,',','.'))
            ->with('totalFilterMsProgramNominalAccountA2BGR', number_format($totalFilterMsProgramNominalAccountA2BGR,0,',','.'))
            
            ->with('jumlahFilterMsProgramAccountPeralatan', number_format($jumlahFilterMsProgramAccountPeralatan,0,',','.'))
            ->with('totalFilterMsProgramNominalAccountPeralatan', number_format($totalFilterMsProgramNominalAccountPeralatan,0,',','.'))
            ->with('jumlahFilterMsProgramAccountPeralatanUser', number_format($jumlahFilterMsProgramAccountPeralatanUser,0,',','.'))
            ->with('totalFilterMsProgramNominalAccountPeralatanUser', number_format($totalFilterMsProgramNominalAccountPeralatanUser,0,',','.'))
            ->with('jumlahFilterMsProgramAccountPeralatanMIR', number_format($jumlahFilterMsProgramAccountPeralatanMIR,0,',','.'))
            ->with('totalFilterMsProgramNominalAccountPeralatanMIR', number_format($totalFilterMsProgramNominalAccountPeralatanMIR,0,',','.'))
            ->with('jumlahFilterMsProgramAccountPeralatanSR', number_format($jumlahFilterMsProgramAccountPeralatanSR,0,',','.'))
            ->with('totalFilterMsProgramNominalAccountPeralatanSR', number_format($totalFilterMsProgramNominalAccountPeralatanSR,0,',','.'))
            ->with('jumlahFilterMsProgramAccountPeralatanPR', number_format($jumlahFilterMsProgramAccountPeralatanPR,0,',','.'))
            ->with('totalFilterMsProgramNominalAccountPeralatanPR', number_format($totalFilterMsProgramNominalAccountPeralatanPR,0,',','.'))
            ->with('jumlahFilterMsProgramAccountPeralatanPO', number_format($jumlahFilterMsProgramAccountPeralatanPO,0,',','.'))
            ->with('totalFilterMsProgramNominalAccountPeralatanPO', number_format($totalFilterMsProgramNominalAccountPeralatanPO,0,',','.'))
            ->with('jumlahFilterMsProgramAccountPeralatanGR', number_format($jumlahFilterMsProgramAccountPeralatanGR,0,',','.'))
            ->with('totalFilterMsProgramNominalAccountPeralatanGR', number_format($totalFilterMsProgramNominalAccountPeralatanGR,0,',','.'))

            ->with('jumlahFilterMsProgramAccountBangunan', number_format($jumlahFilterMsProgramAccountBangunan,0,',','.'))
            ->with('totalFilterMsProgramNominalAccountBangunan', number_format($totalFilterMsProgramNominalAccountBangunan,0,',','.'))
            ->with('jumlahFilterMsProgramAccountBangunanUser', number_format($jumlahFilterMsProgramAccountBangunanUser,0,',','.'))
            ->with('totalFilterMsProgramNominalAccountBangunanUser', number_format($totalFilterMsProgramNominalAccountBangunanUser,0,',','.'))
            ->with('jumlahFilterMsProgramAccountBangunanMIR', number_format($jumlahFilterMsProgramAccountBangunanMIR,0,',','.'))
            ->with('totalFilterMsProgramNominalAccountBangunanMIR', number_format($totalFilterMsProgramNominalAccountBangunanMIR,0,',','.'))
            ->with('jumlahFilterMsProgramAccountBangunanSR', number_format($jumlahFilterMsProgramAccountBangunanSR,0,',','.'))
            ->with('totalFilterMsProgramNominalAccountBangunanSR', number_format($totalFilterMsProgramNominalAccountBangunanSR,0,',','.'))
            ->with('jumlahFilterMsProgramAccountBangunanPR', number_format($jumlahFilterMsProgramAccountBangunanPR,0,',','.'))
            ->with('totalFilterMsProgramNominalAccountBangunanPR', number_format($totalFilterMsProgramNominalAccountBangunanPR,0,',','.'))
            ->with('jumlahFilterMsProgramAccountBangunanPO', number_format($jumlahFilterMsProgramAccountBangunanPO,0,',','.'))
            ->with('totalFilterMsProgramNominalAccountBangunanPO', number_format($totalFilterMsProgramNominalAccountBangunanPO,0,',','.'))
            ->with('jumlahFilterMsProgramAccountBangunanGR', number_format($jumlahFilterMsProgramAccountBangunanGR,0,',','.'))
            ->with('totalFilterMsProgramNominalAccountBangunanGR', number_format($totalFilterMsProgramNominalAccountBangunanGR,0,',','.'))

            ->with('jumlahFilterMsProgramAccountAsetTBWJD', number_format($jumlahFilterMsProgramAccountAsetTBWJD,0,',','.'))
            ->with('totalFilterMsProgramNominalAccountAsetTBWJD', number_format($totalFilterMsProgramNominalAccountAsetTBWJD,0,',','.'))
            ->with('jumlahFilterMsProgramAccountAsetTBWJDUser', number_format($jumlahFilterMsProgramAccountAsetTBWJDUser,0,',','.'))
            ->with('totalFilterMsProgramNominalAccountAsetTBWJDUser', number_format($totalFilterMsProgramNominalAccountAsetTBWJDUser,0,',','.'))
            ->with('jumlahFilterMsProgramAccountAsetTBWJDMIR', number_format($jumlahFilterMsProgramAccountAsetTBWJDMIR,0,',','.'))
            ->with('totalFilterMsProgramNominalAccountAsetTBWJDMIR', number_format($totalFilterMsProgramNominalAccountAsetTBWJDMIR,0,',','.'))
            ->with('jumlahFilterMsProgramAccountAsetTBWJDSR', number_format($jumlahFilterMsProgramAccountAsetTBWJDSR,0,',','.'))
            ->with('totalFilterMsProgramNominalAccountAsetTBWJDSR', number_format($totalFilterMsProgramNominalAccountAsetTBWJDSR,0,',','.'))
            ->with('jumlahFilterMsProgramAccountAsetTBWJDPR', number_format($jumlahFilterMsProgramAccountAsetTBWJDPR,0,',','.'))
            ->with('totalFilterMsProgramNominalAccountAsetTBWJDPR', number_format($totalFilterMsProgramNominalAccountAsetTBWJDPR,0,',','.'))
            ->with('jumlahFilterMsProgramAccountAsetTBWJDPO', number_format($jumlahFilterMsProgramAccountAsetTBWJDPO,0,',','.'))
            ->with('totalFilterMsProgramNominalAccountAsetTBWJDPO', number_format($totalFilterMsProgramNominalAccountAsetTBWJDPO,0,',','.'))
            ->with('jumlahFilterMsProgramAccountAsetTBWJDGR', number_format($jumlahFilterMsProgramAccountAsetTBWJDGR,0,',','.'))
            ->with('totalFilterMsProgramNominalAccountAsetTBWJDGR', number_format($totalFilterMsProgramNominalAccountAsetTBWJDGR,0,',','.'))

            ->with('jumlahFilterMsProgramAccountSCP', number_format($jumlahFilterMsProgramAccountSCP,0,',','.'))
            ->with('totalFilterMsProgramNominalAccountSCP', number_format($totalFilterMsProgramNominalAccountSCP,0,',','.'))
            ->with('jumlahFilterMsProgramAccountSCPUser', number_format($jumlahFilterMsProgramAccountSCPUser,0,',','.'))
            ->with('totalFilterMsProgramNominalAccountSCPUser', number_format($totalFilterMsProgramNominalAccountSCPUser,0,',','.'))
            ->with('jumlahFilterMsProgramAccountSCPMIR', number_format($jumlahFilterMsProgramAccountSCPMIR,0,',','.'))
            ->with('totalFilterMsProgramNominalAccountSCPMIR', number_format($totalFilterMsProgramNominalAccountSCPMIR,0,',','.'))
            ->with('jumlahFilterMsProgramAccountSCPSR', number_format($jumlahFilterMsProgramAccountSCPSR,0,',','.'))
            ->with('totalFilterMsProgramNominalAccountSCPSR', number_format($totalFilterMsProgramNominalAccountSCPSR,0,',','.'))
            ->with('jumlahFilterMsProgramAccountSCPPR', number_format($jumlahFilterMsProgramAccountSCPPR,0,',','.'))
            ->with('totalFilterMsProgramNominalAccountSCPPR', number_format($totalFilterMsProgramNominalAccountSCPPR,0,',','.'))
            ->with('jumlahFilterMsProgramAccountSCPPO', number_format($jumlahFilterMsProgramAccountSCPPO,0,',','.'))
            ->with('totalFilterMsProgramNominalAccountSCPPO', number_format($totalFilterMsProgramNominalAccountSCPPO,0,',','.'))
            ->with('jumlahFilterMsProgramAccountSCPGR', number_format($jumlahFilterMsProgramAccountSCPGR,0,',','.'))
            ->with('totalFilterMsProgramNominalAccountSCPGR', number_format($totalFilterMsProgramNominalAccountSCPGR,0,',','.'))

            ->with('jumlahFilterMsProgramAccount', number_format($jumlahFilterMsProgramAccount,0,',','.'))
            ->with('totalFilterMsProgramNominalAccount', number_format($totalFilterMsProgramNominalAccount,0,',','.'))
            ->with('jumlahFilterMsProgramAccountUser', number_format($jumlahFilterMsProgramAccountUser,0,',','.'))
            ->with('totalFilterMsProgramNominalAccountUser', number_format($totalFilterMsProgramNominalAccountUser,0,',','.'))
            ->with('jumlahFilterMsProgramAccountMIR', number_format($jumlahFilterMsProgramAccountMIR,0,',','.'))
            ->with('totalFilterMsProgramNominalAccountMIR', number_format($totalFilterMsProgramNominalAccountMIR,0,',','.'))
            ->with('jumlahFilterMsProgramAccountSR', number_format($jumlahFilterMsProgramAccountSR,0,',','.'))
            ->with('totalFilterMsProgramNominalAccountSR', number_format($totalFilterMsProgramNominalAccountSR,0,',','.'))
            ->with('jumlahFilterMsProgramAccountPR', number_format($jumlahFilterMsProgramAccountPR,0,',','.'))
            ->with('totalFilterMsProgramNominalAccountPR', number_format($totalFilterMsProgramNominalAccountPR,0,',','.'))
            ->with('jumlahFilterMsProgramAccountPO', number_format($jumlahFilterMsProgramAccountPO,0,',','.'))
            ->with('totalFilterMsProgramNominalAccountPO', number_format($totalFilterMsProgramNominalAccountPO,0,',','.'))
            ->with('jumlahFilterMsProgramAccountGR', number_format($jumlahFilterMsProgramAccountGR,0,',','.'))
            ->with('totalFilterMsProgramNominalAccountGR', number_format($totalFilterMsProgramNominalAccountGR,0,',','.'))
            
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
                </div>
                <!--begin::User details-->
                ';

                return $html;
            })
            ->addColumn('fild_kriteria', function($row)
            {
                $html = '
                <!--begin::User details-->
                <div class="d-flex flex-column">
                    <a href="#" class="text-gray-800 text-hover-primary mb-1 fw-bolder fs-5">'.$row->kriteria_pengadaan.'</a>
                    <small>'.$row->kriteria_program.'</small>
                    <hr>
                </div>
                <!--begin::User details-->
                ';

                return $html;
            })
            ->addColumn('fild_departement', function($row)
            {
                $html = '
                <!--begin::User details-->
                <div class="d-flex flex-column">
                    <a href="#" class="text-gray-800 text-hover-primary mb-1 fw-bolder fs-5">'.$row->name_program_departement_cck.'</a>
                    <small>'.$row->name_program_bagian_cc.'</small>
                    <hr>
                </div>
                <!--begin::User details-->
                ';

                return $html;
            })
            ->addColumn('fild_direktorat', function($row)
            {
                $html = '
                <!--begin::User details-->
                <div class="d-flex flex-column">
                    <a href="#" class="text-gray-800 text-hover-primary mb-1 fw-bolder fs-5">'.$row->direktorat.'</a>
                    <small>'.$row->kompartemen.'</small>
                    <hr>
                </div>
                <!--begin::User details-->
                ';

                return $html;
            })
            ->addColumn('fild_account', function($row)
            {
                $html = '
                <!--begin::User details-->
                <div class="d-flex flex-column text-start">
                    <a href="#" class="text-gray-800 text-hover-primary mb-1 fw-bold">'.$row->name_program_account.'</a>
                </div>
                <!--begin::User details-->
                ';

                return $html;
            })
            ->addColumn('fild_priority', function($row)
            {
                $html = '
                <!--begin::User details-->
                <div class="d-flex flex-column text-start">
                    <a href="#" class="text-gray-800 text-hover-primary mb-1 fw-bold">'.strtoupper($row->priority).'</a>
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
            ->addColumn('action', function($row)
            {
                if($row->status == 1)
                {
                    $dataStaus = 'nonaktif';
                }else{
                    $dataStaus = 'aktivasi';
                }

                // $html = '<div class="dropdown">
                //     <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                //     Action
                //     </button>
                //     <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                //         <li><a class="dropdown-item" href="#" data-id="'.$row->uuid.'" onclick="act_btnDetailData(this)">Detail Data</a></li>
                //         <li><a class="dropdown-item" href="#" data-id="'.$row->uuid.'" onclick="act_btnUpdateData(this)">Update Data</a></li>
                //         <li><a class="dropdown-item" href="#" data-id="'.$row->uuid.'" data-status="'.$dataStaus.'" onclick="act_UpdateStatusData(this)">Change Status</a></li>
                //     </ul>
                // </div>
                // ';

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
            ->rawColumns(['fund_number', 'fild_name', 'fild_kriteria', 'fild_departement', 'fild_direktorat', 'fild_account', 'fild_priority', 'fild_nominal', 'action'])
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
