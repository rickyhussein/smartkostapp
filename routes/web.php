<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BankController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\RentController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VillageController;
use App\Http\Controllers\DistrictController;
use App\Http\Controllers\FacilityController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\ProvinceController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RegulationController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\UserPropertyController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [AuthController::class, 'index'])->middleware('guest');
Route::get('/login', [AuthController::class, 'login'])->name('login')->middleware('guest');
Route::post('/login/store', [AuthController::class, 'storeLogin'])->middleware('guest');
Route::get('/register', [AuthController::class, 'register'])->middleware('guest');
Route::get('/register/user', [AuthController::class, 'userRegister'])->middleware('guest');
Route::post('/register/user/store', [AuthController::class, 'storeUserRegister'])->middleware('guest');
Route::get('/register/owner', [AuthController::class, 'ownerRegister'])->middleware('guest');
Route::post('/register/owner/store', [AuthController::class, 'storeOwnerRegister'])->middleware('guest');
Route::get('/forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('/forgot-password/link', [AuthController::class, 'forgotPasswordLink']);
Route::get('reset-password/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
Route::post('reset-password', [AuthController::class, 'reset'])->name('password.update');
Route::get('/logout', [AuthController::class, 'logout'])->middleware('auth');
Route::get('/switch/{id}', [AuthController::class, 'switch']);

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth');
Route::get('/dashboard/user', [dashboardController::class, 'userDashboard'])->middleware('auth');
Route::get('/dashboard/owner', [dashboardController::class, 'ownerDashboard'])->middleware('auth');

Route::get('/users', [UserController::class, 'index'])->middleware('auth');
Route::get('/users/create', [UserController::class, 'create'])->middleware('auth');
Route::post('/users/store', [UserController::class, 'store'])->middleware('auth');
Route::get('/users/edit/{id}', [UserController::class, 'edit'])->middleware('auth');
Route::put('/users/update/{id}', [UserController::class, 'update'])->middleware('auth');
Route::get('/users/password/edit/{id}', [UserController::class, 'editPassword'])->middleware('auth');
Route::put('/users/password/update/{id}', [UserController::class, 'updatePassword'])->middleware('auth');
Route::delete('/users/delete/{id}', [UserController::class, 'delete'])->middleware('auth');

Route::get('/profile', [UserController::class, 'profile'])->middleware('auth');
Route::put('/profile/update/{id}', [UserController::class, 'updateProfile'])->middleware('auth');

Route::get('/password/edit', [UserController::class, 'editPasswordAdmin'])->middleware('auth');
Route::put('/password/update/{id}', [UserController::class, 'updatePasswordAdmin'])->middleware('auth');

Route::get('/password/owner/edit', [UserController::class, 'editPasswordOwner'])->middleware('auth');

Route::get('/password/user/edit', [UserController::class, 'editPasswordUser'])->middleware('auth');

Route::get('/profile/owner', [UserController::class, 'ownerProfile'])->middleware('auth');
Route::put('/profile/owner/update/{id}', [UserController::class, 'updateOwnerProfile'])->middleware('auth');

Route::get('/profile/user', [UserController::class, 'userProfile'])->middleware('auth');
Route::put('/profile/user/update/{id}', [UserController::class, 'updateUserProfile'])->middleware('auth');

Route::get('/roles', [RoleController::class, 'index'])->middleware('auth');
Route::get('/roles/create', [RoleController::class, 'create'])->middleware('auth');
Route::post('/roles/store', [RoleController::class, 'store'])->middleware('auth');
Route::get('/roles/edit/{id}', [RoleController::class, 'edit'])->middleware('auth');
Route::put('/roles/update/{id}', [RoleController::class, 'update'])->middleware('auth');
Route::delete('/roles/delete/{id}', [RoleController::class, 'delete'])->middleware('auth');

Route::get('/permissions', [PermissionController::class, 'index'])->middleware('auth');
Route::get('/permissions/create', [PermissionController::class, 'create'])->middleware('auth');
Route::post('/permissions/store', [PermissionController::class, 'store'])->middleware('auth');
Route::get('/permissions/edit/{id}', [PermissionController::class, 'edit'])->middleware('auth');
Route::put('/permissions/update/{id}', [PermissionController::class, 'update'])->middleware('auth');
Route::delete('/permissions/delete/{id}', [PermissionController::class, 'delete'])->middleware('auth');

Route::get('/notifications', [NotificationController::class, 'index'])->middleware('auth');
Route::get('/notifications/owner', [NotificationController::class, 'ownerNotifications'])->middleware('auth');
Route::get('/notifications/user', [NotificationController::class, 'userNotifications'])->middleware('auth');
Route::get('/notifications/read-message/{id}', [NotificationController::class, 'readMessage'])->middleware('auth');

Route::get('/regulations', [RegulationController::class, 'index'])->middleware('auth');
Route::get('/regulations/create', [RegulationController::class, 'create'])->middleware('auth');
Route::post('/regulations/store', [RegulationController::class, 'store'])->middleware('auth');
Route::get('/regulations/edit/{id}', [RegulationController::class, 'edit'])->middleware('auth');
Route::put('/regulations/update/{id}', [RegulationController::class, 'update'])->middleware('auth');
Route::delete('/regulations/delete/{id}', [RegulationController::class, 'delete'])->middleware('auth');

Route::get('/banks', [BankController::class, 'index'])->middleware('auth');
Route::get('/banks/create', [BankController::class, 'create'])->middleware('auth');
Route::post('/banks/store', [BankController::class, 'store'])->middleware('auth');
Route::get('/banks/edit/{id}', [BankController::class, 'edit'])->middleware('auth');
Route::put('/banks/update/{id}', [BankController::class, 'update'])->middleware('auth');
Route::delete('/banks/delete/{id}', [BankController::class, 'delete'])->middleware('auth');

Route::get('/facilities', [FacilityController::class, 'index'])->middleware('auth');
Route::get('/facilities/create', [FacilityController::class, 'create'])->middleware('auth');
Route::post('/facilities/store', [FacilityController::class, 'store'])->middleware('auth');
Route::get('/facilities/edit/{id}', [FacilityController::class, 'edit'])->middleware('auth');
Route::put('/facilities/update/{id}', [FacilityController::class, 'update'])->middleware('auth');
Route::delete('/facilities/delete/{id}', [FacilityController::class, 'delete'])->middleware('auth');

Route::get('/provinces', [ProvinceController::class, 'index'])->middleware('auth');
Route::post('/provinces/import', [ProvinceController::class, 'import'])->middleware('auth');
Route::get('/provinces/create', [ProvinceController::class, 'create'])->middleware('auth');
Route::post('/provinces/store', [ProvinceController::class, 'store'])->middleware('auth');
Route::get('/provinces/edit/{id}', [ProvinceController::class, 'edit'])->middleware('auth');
Route::put('/provinces/update/{id}', [ProvinceController::class, 'update'])->middleware('auth');
Route::delete('/provinces/delete/{id}', [ProvinceController::class, 'delete'])->middleware('auth');

Route::get('/cities', [CityController::class, 'index'])->middleware('auth');
Route::post('/cities/import', [CityController::class, 'import'])->middleware('auth');
Route::get('/cities/create', [CityController::class, 'create'])->middleware('auth');
Route::post('/cities/store', [CityController::class, 'store'])->middleware('auth');
Route::get('/cities/edit/{id}', [CityController::class, 'edit'])->middleware('auth');
Route::put('/cities/update/{id}', [CityController::class, 'update'])->middleware('auth');
Route::delete('/cities/delete/{id}', [CityController::class, 'delete'])->middleware('auth');

Route::get('/districts', [DistrictController::class, 'index'])->middleware('auth');
Route::post('/districts/import', [DistrictController::class, 'import'])->middleware('auth');
Route::get('/districts/create', [DistrictController::class, 'create'])->middleware('auth');
Route::post('/districts/store', [DistrictController::class, 'store'])->middleware('auth');
Route::get('/districts/edit/{id}', [DistrictController::class, 'edit'])->middleware('auth');
Route::put('/districts/update/{id}', [DistrictController::class, 'update'])->middleware('auth');
Route::delete('/districts/delete/{id}', [DistrictController::class, 'delete'])->middleware('auth');

Route::get('/villages', [VillageController::class, 'index'])->middleware('auth');
Route::post('/villages/import', [VillageController::class, 'import'])->middleware('auth');
Route::get('/villages/create', [VillageController::class, 'create'])->middleware('auth');
Route::post('/villages/store', [VillageController::class, 'store'])->middleware('auth');
Route::get('/villages/edit/{id}', [VillageController::class, 'edit'])->middleware('auth');
Route::put('/villages/update/{id}', [VillageController::class, 'update'])->middleware('auth');
Route::delete('/villages/delete/{id}', [VillageController::class, 'delete'])->middleware('auth');

Route::get('/news', [NewsController::class, 'index'])->middleware('auth');
Route::get('/news/create', [NewsController::class, 'create'])->middleware('auth');
Route::post('/news/store', [NewsController::class, 'store'])->middleware('auth');
Route::get('/news/edit/{id}', [NewsController::class, 'edit'])->middleware('auth');
Route::put('/news/update/{id}', [NewsController::class, 'update'])->middleware('auth');
Route::delete('/news/delete/{id}', [NewsController::class, 'delete'])->middleware('auth');

Route::get('/news/user', [NewsController::class, 'userNews']);
Route::get('/news/user/show/{id}', [NewsController::class, 'showUserNews']);

Route::get('/news/owner', [NewsController::class, 'ownerNews'])->middleware('auth');
Route::get('/news/owner/show/{id}', [NewsController::class, 'showOwnerNews'])->middleware('auth');

Route::get('/properties', [PropertyController::class, 'index'])->middleware('auth');
Route::get('/properties/show/{id}', [PropertyController::class, 'show'])->middleware('auth');
Route::post('/properties/approve/{id}', [PropertyController::class, 'approve'])->middleware('auth');
Route::post('/properties/reject/{id}', [PropertyController::class, 'reject'])->middleware('auth');
Route::get('/properties/room/show/{room_id}/{property_id}', [PropertyController::class, 'showRoom'])->middleware('auth');

Route::get('/properties/owner', [PropertyController::class, 'ownerProperties'])->middleware('auth');
Route::get('/properties/owner/create', [PropertyController::class, 'createOwnerProperties'])->middleware('auth');
Route::post('/properties/owner/store', [PropertyController::class, 'storeOwnerProperties'])->middleware('auth');
Route::get('/properties/owner/show/{id}', [PropertyController::class, 'showOwnerProperties'])->middleware('auth');
Route::get('/properties/owner/edit/{id}', [PropertyController::class, 'editOwnerProperties'])->middleware('auth');
Route::put('/properties/owner/update/{id}', [PropertyController::class, 'updateOwnerProperties'])->middleware('auth');
Route::delete('/properties/owner/delete/{id}', [PropertyController::class, 'deleteOwnerProperties'])->middleware('auth');

Route::get('/properties/owner/room/show/{room_id}/{property_id}', [PropertyController::class, 'showRoomOwnerProperties'])->middleware('auth');
Route::get('/properties/owner/room/create/{room_id}/{property_id}', [PropertyController::class, 'createRoomOwnerProperties'])->middleware('auth');
Route::post('/properties/owner/room/store/{room_id}/{property_id}', [PropertyController::class, 'storeRoomOwnerProperties'])->middleware('auth');

Route::get('/properties/user', [PropertyController::class, 'userProperties']);
Route::get('/properties/user/show/{id}', [PropertyController::class, 'showUserProperties']);
Route::get('/properties/user/room/show/{room_id}/{property_id}', [PropertyController::class, 'showRoomUserProperties']);
Route::get('/properties/user/rents/{id}', [PropertyController::class, 'rentUserProperties'])->middleware('auth');
Route::post('/properties/user/rents/store/{id}', [PropertyController::class, 'storeRentUserProperties'])->middleware('auth');

Route::get('/rents/user', [RentController::class, 'userRent'])->middleware('auth');
Route::get('/rents/user/show/{id}', [RentController::class, 'showUserRent'])->middleware('auth');

Route::get('/rents/owner', [RentController::class, 'ownerRent'])->middleware('auth');
Route::get('/rents/owner/show/{id}', [RentController::class, 'showOwnerRent'])->middleware('auth');
Route::post('/rents/owner/approval/{id}', [RentController::class, 'approvalOwnerRent'])->middleware('auth');

Route::get('/user-properties', [UserPropertyController::class, 'index'])->middleware('auth');
Route::get('/user-properties/show/{id}', [UserPropertyController::class, 'show'])->middleware('auth');
Route::get('/user-properties/contract/{id}', [UserPropertyController::class, 'contract'])->middleware('auth');
Route::post('/user-properties/signature/{id}', [UserPropertyController::class, 'signature'])->middleware('auth');

Route::get('/user-properties/owner', [UserPropertyController::class, 'ownerUp'])->middleware('auth');
Route::get('/user-properties/owner/show/{id}', [UserPropertyController::class, 'showOwnerUp'])->middleware('auth');
Route::get('/user-properties/owner/contract/print/{id}', [UserPropertyController::class, 'printContractOwnerUp'])->middleware('auth');
Route::get('/user-properties/owner/contract/edit/{id}', [UserPropertyController::class, 'editContractOwnerUp'])->middleware('auth');
Route::put('/user-properties/owner/contract/update/{id}', [UserPropertyController::class, 'updateContractOwnerUp'])->middleware('auth');

Route::get('/get-city', [PropertyController::class, 'getCity'])->middleware('auth');
Route::get('/get-district', [PropertyController::class, 'getDistrict'])->middleware('auth');
Route::get('/get-village', [PropertyController::class, 'getVillage'])->middleware('auth');
Route::get('/get-room', [PropertyController::class, 'getRoom'])->middleware('auth');

Route::get('/reset', function () {
    Artisan::call('optimize');
    Artisan::call('config:cache');
    Artisan::call('route:clear');
    Artisan::call('migrate:fresh --seed');
    Artisan::call('storage:link');
});

Route::get('/migrate', function () {
    Artisan::call('optimize');
    Artisan::call('config:cache');
    Artisan::call('route:clear');
    Artisan::call('migrate');
});

Route::get('/optimize', function () {
    Artisan::call('optimize');
    Artisan::call('config:cache');
    Artisan::call('route:clear');
});
