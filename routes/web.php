<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::group(['middleware' => 'auth'], function ()
{

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/find', [App\Http\Controllers\asset_controller::class, 'find'])->name('find');

// asset
Route::get('/find_asset_details', [App\Http\Controllers\asset_controller::class, 'find_asset_details'])->name('find_asset_details');
Route::get('/view_user/{id}', [App\Http\Controllers\asset_controller::class, 'view_user'])->name('view_user');
Route::POST('/update_asset_user_data', [App\Http\Controllers\asset_controller::class, 'update_asset_user_data'])->name('update_asset_user_data');
Route::POST('/update_other_asset_user_data', [App\Http\Controllers\asset_controller::class, 'update_other_asset_user_data'])->name('update_other_asset_user_data');
Route::POST('/return_asset', [App\Http\Controllers\asset_controller::class, 'return_asset'])->name('return_asset');
Route::POST('/return_other_asset', [App\Http\Controllers\asset_controller::class, 'return_other_asset'])->name('return_other_asset');
Route::POST('/add_asset_data', [App\Http\Controllers\asset_controller::class, 'add_asset_data'])->name('add_asset_data');
Route::POST('/add_other_asset_data', [App\Http\Controllers\asset_controller::class, 'add_other_asset_data'])->name('add_other_asset_data');
Route::POST('/insert_new_asset_data', [App\Http\Controllers\asset_controller::class, 'insert_new_asset_data'])->name('insert_new_asset_data');
Route::get('/find_asset', [App\Http\Controllers\asset_controller::class, 'find_asset'])->name('find_asset');
Route::POST('/find_asset_data_details', [App\Http\Controllers\asset_controller::class, 'find_asset_data_details'])->name('find_asset_data_details');
Route::get('/unallocated_asset', [App\Http\Controllers\asset_controller::class, 'unallocated_asset'])->name('unallocated_asset');
Route::POST('/add_unallocated_data', [App\Http\Controllers\asset_controller::class, 'add_unallocated_data'])->name('add_unallocated_data');

Route::get('/allocate_asset/{id}', [App\Http\Controllers\asset_controller::class, 'allocate_asset'])->name('allocate_asset');
Route::POST('/allcate_asset_user', [App\Http\Controllers\asset_controller::class, 'allcate_asset_user'])->name('allcate_asset_user');


// dongle
Route::POST('/update_dongle_user_data', [App\Http\Controllers\dongle_controller::class, 'update_dongle_user_data'])->name('update_dongle_user_data');
Route::POST('/return_dongle', [App\Http\Controllers\dongle_controller::class, 'return_dongle'])->name('return_dongle');
Route::POST('/add_dongle_user_data', [App\Http\Controllers\dongle_controller::class, 'add_dongle_user_data'])->name('add_dongle_user_data');
Route::get('/find_dongle_data', [App\Http\Controllers\dongle_controller::class, 'find_dongle_data'])->name('find_dongle_data');
Route::POST('/find_dongle_data_details', [App\Http\Controllers\dongle_controller::class, 'find_dongle_data_details'])->name('find_dongle_data_details');
Route::get('/unallocated_dongle', [App\Http\Controllers\dongle_controller::class, 'unallocated_dongle'])->name('unallocated_dongle');
Route::POST('/add_unallocated_dongle_data', [App\Http\Controllers\dongle_controller::class, 'add_unallocated_dongle_data'])->name('add_unallocated_dongle_data');
Route::get('/allocate_dongle/{id}', [App\Http\Controllers\dongle_controller::class, 'allocate_dongle'])->name('allocate_dongle');
Route::POST('/allcate_dongle_user', [App\Http\Controllers\dongle_controller::class, 'allcate_dongle_user'])->name('allcate_dongle_user');


// new user add
Route::get('/add_new', [App\Http\Controllers\user_controller::class, 'add_new'])->name('add_new');
Route::POST('/employee_validation', [App\Http\Controllers\user_controller::class, 'employee_validation'])->name('employee_validation');
Route::POST('/employee_details_validation', [App\Http\Controllers\user_controller::class, 'employee_details_validation'])->name('employee_details_validation');
Route::POST('/deactivate_user_account', [App\Http\Controllers\user_controller::class, 'deactivate_user_account'])->name('deactivate_user_account');
Route::POST('/activate_account', [App\Http\Controllers\user_controller::class, 'activate_account'])->name('activate_account');

// find new emplyee
Route::POST('/find_emp_details', [App\Http\Controllers\asset_controller::class, 'find_emp_details'])->name('find_emp_details');

// users

Route::get('/all_user', [App\Http\Controllers\user_controller::class, 'all_user'])->name('all_user');
Route::POST('/user_update_details', [App\Http\Controllers\user_controller::class, 'user_update_details'])->name('user_update_details');
Route::POST('/remove_users', [App\Http\Controllers\user_controller::class, 'remove_users'])->name('remove_users');
Route::POST('/change_user_password', [App\Http\Controllers\user_controller::class, 'change_user_password'])->name('change_user_password');


// report
Route::get('/asset_report', [App\Http\Controllers\asset_controller::class, 'asset_report'])->name('asset_report');
Route::get('/dongle_report', [App\Http\Controllers\dongle_controller::class, 'dongle_report'])->name('dongle_report');
Route::get('/user_report', [App\Http\Controllers\user_controller::class, 'user_report'])->name('user_report');

});