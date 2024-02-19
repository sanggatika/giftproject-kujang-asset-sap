<?php

use Illuminate\Support\Facades\Route;

// Controller
use App\Http\Controllers\LandingController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\DashboardController;

// Management
use App\Http\Controllers\ManagementMenuController;
use App\Http\Controllers\ManagementRoleController;
use App\Http\Controllers\ManagementUsersController;
use App\Http\Controllers\ManagementAccountController;

// Masterdata
use App\Http\Controllers\MasterdataProgramController;

// Transaksi
use App\Http\Controllers\TrProgresProgramSRController;
use App\Http\Controllers\TrProgresProgramPRController;
use App\Http\Controllers\TrProgresProgramPOController;
use App\Http\Controllers\TrProgresProgramGRController;
use App\Http\Controllers\TrProgramRealisasiController;
use App\Http\Controllers\TrProgramPrognosaController;
use App\Http\Controllers\TrProgresImportController;

// Development
use App\Http\Controllers\DevelopmentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::group(['middleware' => ['log.access']], function () {
    // Route::get('/', function () {
    //     return view('welcome');
    // });
    Route::get('/', [LandingController::class, 'page_homeLanding'])->name('landing');
    Route::get('/tracking/purchases/{data_uuid}', [LandingController::class, 'page_trackingPurchasesLanding'])->name('landing.purchases.penjualan');
    Route::get('/tracking/penjualan/{data_uuid}', [LandingController::class, 'page_trackingPenjualanLanding'])->name('landing.tracking.penjualan');
    Route::get('/tracking/penjualan-second/{data_uuid}', [LandingController::class, 'page_trackingPenjualanFakeLanding'])->name('landing.tracking.penjualan.fake');
});

Route::group(['middleware' => ['auth', 'log.access']], function () {
    Route::get('/dash', [DashboardController::class, 'page_admDashboard'])->name('dash');
    Route::get('/dash/admin', [DashboardController::class, 'page_admDashboard'])->name('dash.admin');
    Route::get('/dash/transaksi', [DashboardController::class, 'page_transaksiDashboard'])->name('dash.transaksi');
    Route::get('/dash/program_anggaran', [DashboardController::class, 'page_programDashboard'])->name('dash.program_anggaran');
    Route::get('/dash/progres_realisasi', [DashboardController::class, 'page_realisasiDashboard'])->name('dash.progres_realisasi');
    Route::get('/dash/prognosa', [DashboardController::class, 'page_prognosaDashboard'])->name('dash.prognosa');
    Route::get('/dash/prognosa/{filter_tanggal}', [DashboardController::class, 'page_prognosaDashboard'])->name('dash.prognosa');

    // Management Menu
    Route::get('/management/menu', [ManagementMenuController::class, 'page_indexManagementMenu'])->name('management.menu');
    Route::post('/management/menu/act_tambah', [ManagementMenuController::class, 'act_tambahManagementMenu'])->name('management.menu.act_tambah');
    Route::post('/management/menu/get_detail', [ManagementMenuController::class, 'get_detailManagementMenu'])->name('management.menu.get_detail');
    Route::post('/management/menu/act_edit', [ManagementMenuController::class, 'act_editManagementMenu'])->name('management.menu.act_edit');
    Route::post('/management/menu/act_edit_status', [ManagementMenuController::class, 'act_editstatusManagementMenu'])->name('management.menu.act_edit_status');
    Route::post('/management/menu/act_sort', [ManagementMenuController::class, 'act_sortManagementMenu'])->name('management.menu.act_sort');

    // Management Role
    Route::get('/management/role', [ManagementRoleController::class, 'page_indexManagementRole'])->name('management.role');
    Route::post('/management/role/act_tambah', [ManagementRoleController::class, 'act_tambahManagementRole'])->name('management.role.act_tambah');
    Route::post('/management/role/get_detail', [ManagementRoleController::class, 'get_detailManagementRole'])->name('management.role.get_detail');
    Route::post('/management/role/act_edit', [ManagementRoleController::class, 'act_editManagementRole'])->name('management.role.act_edit');
    Route::post('/management/role/act_edit_status', [ManagementRoleController::class, 'act_editstatusManagementRole'])->name('management.role.act_edit_status');
    Route::get('/management/role/hakakses/{data_role}', [ManagementRoleController::class, 'page_hakaksesManagementRole'])->name('management.role.hakakses');
    Route::post('/management/role/act_hakakses', [ManagementRoleController::class, 'act_hakaksesManagementRole'])->name('management.role.act_hakakses');

    // Management Users
    Route::get('/management/users', [ManagementUsersController::class, 'page_indexManagementUsers'])->name('management.users');
    Route::post('/management/users/get_datatable', [ManagementUsersController::class, 'get_datatableManagementUsers'])->name('management.users.get_datatable');
    Route::post('/management/users/act_tambah', [ManagementUsersController::class, 'act_tambahManagementUsers'])->name('management.users.act_tambah');
    Route::post('/management/users/act_detail', [ManagementUsersController::class, 'act_detailManagementUsers'])->name('management.users.act_detail');
    Route::post('/management/users/act_update', [ManagementUsersController::class, 'act_updateManagementUsers'])->name('management.users.act_update');
    Route::post('/management/users/act_update_status', [ManagementUsersController::class, 'act_update_statusManagementUsers'])->name('management.users.act_update_status');

    // Management Account
    Route::get('/management/account', [ManagementAccountController::class, 'page_indexManagementAccount'])->name('management.account');
    Route::post('/management/account/password/act_update', [ManagementAccountController::class, 'act_updatePasswordManagementAccount'])->name('management.account.password.act_update');

    // Masterdata Program Anggaran
    Route::get('/masterdata/program', [MasterdataProgramController::class, 'page_indexMasterdataProgram'])->name('masterdata.program');
    Route::post('/masterdata/program/get_datatable', [MasterdataProgramController::class, 'get_datatableMasterdataProgram'])->name('masterdata.program.get_datatable');
    Route::post('/masterdata/program/act_tambah', [MasterdataProgramController::class, 'act_tambahMasterdataProgram'])->name('masterdata.program.act_tambah');
    Route::post('/masterdata/program/act_upload', [MasterdataProgramController::class, 'act_uploadMasterdataProgram'])->name('masterdata.program.act_upload');
    Route::post('/masterdata/program/act_detail', [MasterdataProgramController::class, 'act_detailMasterdataProgram'])->name('masterdata.program.act_detail');
    Route::post('/masterdata/program/act_update', [MasterdataProgramController::class, 'act_updateMasterdataProgram'])->name('masterdata.program.act_update');

    // Transaksi Progres Program SR
    Route::get('/transaksi/progres/program/mr_sr', [TrProgresProgramSRController::class, 'page_indexTrProgresProgramSR'])->name('transaksi.progres.program.mr_sr');
    Route::post('/transaksi/progres/program/mr_sr/get_datatable', [TrProgresProgramSRController::class, 'get_datatableTrProgresProgramSR'])->name('transaksi.progres.program.mr_sr.get_datatable');
    Route::post('/transaksi/progres/program/mr_sr/act_detail', [TrProgresProgramSRController::class, 'act_detailTrProgresProgramSR'])->name('transaksi.progres.program.mr_sr.act_detail');
    Route::post('/transaksi/progres/program/mr_sr/act_update', [TrProgresProgramSRController::class, 'act_updateTrProgresProgramSR'])->name('transaksi.progres.program.mr_sr.act_update');

    // Transaksi Progres Program PR
    Route::get('/transaksi/progres/program/pr', [TrProgresProgramPRController::class, 'page_indexTrProgresProgramPR'])->name('transaksi.progres.program.pr');
    Route::post('/transaksi/progres/program/pr/get_datatable', [TrProgresProgramPRController::class, 'get_datatableTrProgresProgramPR'])->name('transaksi.progres.program.pr.get_datatable');
    Route::post('/transaksi/progres/program/pr/act_tambah', [TrProgresProgramPRController::class, 'act_tambahTrProgresProgramPR'])->name('transaksi.progres.program.pr.act_tambah');
    Route::post('/transaksi/progres/program/pr/act_detail', [TrProgresProgramPRController::class, 'act_detailTrProgresProgramPR'])->name('transaksi.progres.program.pr.act_detail');
    Route::post('/transaksi/progres/program/pr/act_update', [TrProgresProgramPRController::class, 'act_updateTrProgresProgramPR'])->name('transaksi.progres.program.pr.act_update');

    // Transaksi Progres Program PO
    Route::get('/transaksi/progres/program/po', [TrProgresProgramPOController::class, 'page_indexTrProgresProgramPO'])->name('transaksi.progres.program.po');
    Route::post('/transaksi/progres/program/po/get_datatable', [TrProgresProgramPOController::class, 'get_datatableTrProgresProgramPO'])->name('transaksi.progres.program.po.get_datatable');
    Route::post('/transaksi/progres/program/po/act_tambah', [TrProgresProgramPOController::class, 'act_tambahTrProgresProgramPO'])->name('transaksi.progres.program.po.act_tambah');
    Route::post('/transaksi/progres/program/po/act_detail', [TrProgresProgramPOController::class, 'act_detailTrProgresProgramPO'])->name('transaksi.progres.program.po.act_detail');
    Route::post('/transaksi/progres/program/po/act_update', [TrProgresProgramPOController::class, 'act_updateTrProgresProgramPO'])->name('transaksi.progres.program.po.act_update');

    // Transaksi Progres Program GR
    Route::get('/transaksi/progres/program/gr', [TrProgresProgramGRController::class, 'page_indexTrProgresProgramGR'])->name('transaksi.progres.program.gr');
    Route::post('/transaksi/progres/program/gr/act_tambah', [TrProgresProgramGRController::class, 'act_tambahTrProgresProgramGR'])->name('transaksi.progres.program.gr.act_tambah');
    Route::post('/transaksi/progres/program/gr/get_datatable', [TrProgresProgramGRController::class, 'get_datatableTrProgresProgramGR'])->name('transaksi.progres.program.gr.get_datatable');
    Route::post('/transaksi/progres/program/gr/act_detail', [TrProgresProgramGRController::class, 'act_detailTrProgresProgramGR'])->name('transaksi.progres.program.gr.act_detail');
    Route::post('/transaksi/progres/program/gr/act_update', [TrProgresProgramGRController::class, 'act_updateTrProgresProgramGR'])->name('transaksi.progres.program.gr.act_update');
    
    // Transaksi Program Realisasi
    Route::get('/transaksi/program/realisasi', [TrProgramRealisasiController::class, 'page_indexTrProgramRealisasi'])->name('transaksi.program.realisasi');
    Route::post('/transaksi/program/realisasi/get_datatable', [TrProgramRealisasiController::class, 'get_datatableTrProgramRealisasi'])->name('transaksi.program.realisasi.get_datatable');

    // Transaksi Program Prognosa
    Route::get('/transaksi/program/prognosa', [TrProgramPrognosaController::class, 'page_indexTrProgramPrognosa'])->name('transaksi.program.prognosa');
    Route::post('/transaksi/program/prognosa/get_datatable', [TrProgramPrognosaController::class, 'get_datatableTrProgramPrognosa'])->name('transaksi.program.prognosa.get_datatable');

    // Transaksi Progres Import
    Route::get('/transaksi/progres/import', [TrProgresImportController::class, 'page_indexTrProgresImport'])->name('transaksi.progres.import');
    Route::post('/transaksi/progres/import/act_upload', [TrProgresImportController::class, 'act_uploadTrProgresImport'])->name('transaksi.progres.import.act_upload');
    Route::post('/transaksi/progres/import/get_datatable', [TrProgresImportController::class, 'get_datatableTrProgresImport'])->name('transaksi.progres.import.get_datatable');
    Route::post('/transaksi/progres/import/cut_off_data', [TrProgresImportController::class, 'act_cutoffdataTrProgresImport'])->name('transaksi.progres.import.cut_off_data');
});

Route::group(['middleware' => ['guest', 'log.access']], function () {
    Route::get('/auth', [AuthenticationController::class, 'page_loginAuthentication'])->name('auth');
    Route::get('/auth/login', [AuthenticationController::class, 'page_loginAuthentication'])->name('auth.login');
    Route::get('/auth/register', [AuthenticationController::class, 'page_registerAuthentication'])->name('auth.register');
    Route::get('/auth/forgot', [AuthenticationController::class, 'page_forgotAuthentication'])->name('auth.forgot');
    Route::get('/auth/reset-password/{token}', [AuthenticationController::class, 'page_resetpasswordAuthentication'])->name('auth.reset-password');
    Route::get('/auth/two-factor/{token}', [AuthenticationController::class, 'page_twofactorAuthentication'])->name('auth.two-factor');

    Route::post('/auth/login/act', [AuthenticationController::class, 'act_loginAuthentication'])->name('auth.login.act');
    Route::post('/auth/forgot/act', [AuthenticationController::class, 'act_forgotAuthentication'])->name('auth.forgot.act');
    Route::post('/auth/reset-password/act', [AuthenticationController::class, 'act_resetAuthentication'])->name('auth.reset-password.act');
    Route::post('/auth/register/act', [AuthenticationController::class, 'act_registerAuthentication'])->name('auth.register.act');
    Route::post('/auth/two-factor/act', [AuthenticationController::class, 'act_twofactorAuthentication'])->name('auth.two-factor.act');
});

Route::group(['middleware' => ['log.access']], function () {
    Route::get('/auth/logout', [AuthenticationController::class, 'logoutAuthentication'])->name('auth.logout');
});

// Development
Route::group(['middleware' => ['log.access']], function () {
    Route::get('/dev/page', [DevelopmentController::class, 'page_indexDevelopment'])->name('dev.page');
    Route::get('/dev/view/qr-code/{file_name}', [DevelopmentController::class, 'view_qrcodeDevelopment'])->name('dev.view.qrcode');
    Route::get('/dev/generate/qr-code', [DevelopmentController::class, 'generate_qrcodeDevelopment'])->name('dev.generate.qrcode');
});

Route::fallback( function () {
    abort( 404 );
} );

