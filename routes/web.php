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
    Route::post('/masterdata/program/act_detail', [MasterdataProgramController::class, 'act_detailMasterdataProgram'])->name('masterdata.program.act_detail');
    Route::post('/masterdata/program/act_update', [MasterdataProgramController::class, 'act_updateMasterdataProgram'])->name('masterdata.program.act_update');
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

