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


Auth::routes(['register' => false]);
Route::middleware('access')->group(function () {
    Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
    Route::post('register', 'Auth\RegisterController@register');
    Route::get('cabinet', 'CabinetController@get_page')->name('cabinet');
    Route::get('/', function () {
        return view('public.home');
    });
    Route::get('profile-settings', 'UserController@profile')->name('profile.settings');
    Route::get('desk/show/{id}', 'DeskController@show')->name('desk.show');
    //AJAX
    Route::get('/self_cabinet/datatable', 'CabinetController@datatableData')->name('self.cabinet.table');
});

Route::prefix('admin')->name('admin.')/*->middleware('admin')*/
    ->group(function () {
        Route::get('/', 'AdminController@index')->name('admin');
        Route::get('dashboard', 'AdminController@dashboard')->name('dashboard');
        //CRUD for desks
        Route::get('/desks/datatable', 'DeskController@datatableData')->name('desk.datatable.data');
        Route::resource('desks', 'DeskController');
        //CRUD for program
        Route::get('/programs/datatable', 'ProgramController@datatableData')->name('program.datatable.data');
        Route::resource('programs', 'ProgramController');

    });
    

