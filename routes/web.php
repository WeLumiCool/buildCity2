<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use App\Mail\BuildCityMail;
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


Auth::routes(['register' => false, 'verify' => true]);
Route::get('register/{code}', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register')->name('register.post');
Route::get('check_code', 'DeskController@checkExistCode')->name('check.code');

Route::get('mail', function () {
    \Illuminate\Support\Facades\Mail::to('khusan590@gmail.com')->send(new \App\Mail\CityBuild());
   return new \App\Mail\CityBuild();
});
Route::get('/', function () {
    return view('public.home');
})->name('main');
Route::middleware('access')->group(function () {
//    Route::get('/', function () {
//        return view('public.home');
//    })->name('main');
    Route::get('cabinet', 'CabinetController@get_page')->name('cabinet');
    Route::get('profile-settings', 'UserController@profile')->name('profile.settings');
    Route::post('update_profile', 'UserController@change_profile')->name('update.profile');
    Route::get('desk/show/{id}', 'DeskController@publicShow')->name('desk.show');
    //AJAX
    Route::get('/self_cabinet/datatable', 'CabinetController@datatableData')->name('self.cabinet.table');
    Route::get('create_desk', 'DeskController@public_create')->name('create.desk');
    Route::post('store_desk', 'DeskController@public_store')->name('store.desk');
});
Route::middleware('auth')->group(function () {
    Route::get('wait', 'UserController@wait')->name('wait');
});
Route::prefix('admin')->name('admin.')->middleware('admin')
    ->group(function () {
        Route::get('/', 'AdminController@index')->name('admin');
        Route::get('dashboard', 'AdminController@dashboard')->name('dashboard');
        //CRUD for desks
        Route::get('/desks/datatable', 'DeskController@datatableData')->name('desk.datatable.data');
        Route::resource('desks', 'DeskController')->only('index', 'show');
        Route::get('/close-desk/{id}', 'DeskController@closeDesk')->name('close.desk');
        //CRUD for program
        Route::get('/programs/datatable', 'ProgramController@datatableData')->name('program.datatable.data');
        Route::resource('programs', 'ProgramController');
        //CRUD for users
        Route::get('/user/datatable', 'UserController@datatableData')->name('user.datatable.data');
        Route::resource('users', 'UserController');

        Route::get('user_activation', 'UserController@activation')->name('user.activation');
        Route::get('desk_activation', 'DeskController@activation')->name('desk.activation');
        Route::get('change_desk', 'DeskController@change_desk')->name('change.desk');
        Route::get('replace', 'DeskController@replaceShow')->name('desks.replace');
        Route::post('can_replace', 'DeskController@change_desk')->name('desks.make.replace');
        Route::get('get_users_for_replace', 'DeskController@get_users')->name('get_users.replace');
        Route::get('active_datatable', 'DeskController@active_datatable')->name('desk.active.data');
        Route::get('/activated', 'DeskController@activated')->name('activated.index');
        Route::get('/desk_delete/{id}', 'DeskController@destroy')->name('desk_delete');

    });

        Route::get('send-mail', function () {


});


