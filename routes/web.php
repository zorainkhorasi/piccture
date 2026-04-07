<?php

use App\Models\Custom_Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Session;

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

Route::get('/', 'Dashboard@index')->name('/');

Route::middleware(['auth'])->group(function () {
    Route::get('/index', 'Dashboard@index')->name('/');
    Route::get('/dashboard', 'Dashboard@index')->name('dashboard');
    Route::get('rs_linelisting_detail/{type?}/{id?}', 'Dashboard@linelisting_detail')->middleware(['auth'])->name('rs_linelisting_detail');
    Route::post('rs_systematic_randomizer', 'Dashboard@systematic_randomizer')->middleware(['auth'])->name('rs_systematic_randomizer');
    Route::get('rs_randomized_detail/{id?}', 'Dashboard@randomized_detail')->middleware(['auth'])->name('rs_randomized_detail');
    Route::get('make_pdf/{id?}', 'Dashboard@make_pdf')->middleware(['auth'])->name('make_pdf');


  //===================DataCollection
    Route::get('/datacollection', 'DataCollection@index')->name('datacollection');
    //Route::get('/datacollection_detail', 'DataCollection@datacollection_detail')->name('datacollection_detail');

    Route::get('datacollection_detail/{type?}/{id?}', 'DataCollection@datacollection_detail')->middleware(['auth'])->name('datacollection_detail');



    /*=====================================App Users=====================================*/
    Route::get('/App_Users', 'App_Users@index')->name('App_Users');
    Route::post('App_Users/addAppUsers', 'App_Users@addAppUsers')->name('addAppUsers');
    Route::get('App_Users/detail/{id?}', 'App_Users@getUserData')->name('getUserData');
    Route::post('App_Users/editAppUsers', 'App_Users@editAppUsers')->name('editAppUsers');
    Route::post('App_Users/resetPwd', 'App_Users@resetPwd')->name('resetPwd');
    Route::post('App_Users/deleteAppUsers', 'App_Users@deleteAppUsers')->name('deleteAppUsers');

    /*=====================================Apps=====================================*/
    Route::get('apps', 'Apps@index')->name('apps');

    /*=====================================Settings=====================================*/
    Route::prefix('settings')->group(function () {
        Route::get('groups', 'Settings\Group@index')->name('groups');
        Route::post('groups/addGroup', 'Settings\Group@addGroup')->name('addGroup');
        Route::get('groups/detail/{id?}', 'Settings\Group@getGroupData')->name('detailGroup');
        Route::post('groups/editGroup', 'Settings\Group@editGroup')->name('editGroup');
        Route::post('groups/deleteGroup', 'Settings\Group@deleteGroup')->name('deleteGroup');

        Route::get('groupSettings/{id?}', 'Settings\GroupSettings@index')->name('groupSettings');
        Route::get('getFormGroupData/{id?}', 'Settings\GroupSettings@getFormGroupData')->name('getFormGroupData');
        Route::post('fgAdd', 'Settings\GroupSettings@fgAdd')->name('fgAdd');

        Route::get('pages', 'Settings\Pages@index')->name('pages');
        Route::post('pages/addPages', 'Settings\Pages@addPages')->name('addPages');
        Route::get('pages/detail/{id?}', 'Settings\Pages@getPagesData')->name('detailPages');
        Route::post('pages/editPages', 'Settings\Pages@editPages')->name('editPages');
        Route::post('pages/deletePages', 'Settings\Pages@deletePages')->name('deletePages');


        Route::get('Dashboard_Users', 'Settings\Dashboard_Users@index')->name('dashboard_users');
        Route::post('Dashboard_Users/addDashboardUsers', 'Settings\Dashboard_Users@addDashboardUsers')->name('addDashboardUsers');
        Route::get('Dashboard_Users/detail/{id?}', 'Settings\Dashboard_Users@getDashboardUsersData')->name('getDashboardUsersData');
        Route::post('Dashboard_Users/editDashboardUsers', 'Settings\Dashboard_Users@editDashboardUsers')->name('editDashboardUsers');
        Route::post('Dashboard_Users/deleteDashboardUsers', 'Settings\Dashboard_Users@deleteDashboardUsers')->name('deleteDashboardUsers');
        Route::post('Dashboard_Users/resetPwd', 'Settings\Dashboard_Users@resetPwd')->name('resetPwd');
        Route::get('Dashboard_Users/user_log_reports/{id?}', 'Settings\Dashboard_Users@user_log_reports')->name('user_log_reports');

    });
    Route::post('changePassword', 'Settings\Dashboard_Users@changePassword')->name('changePassword');
});







Route::get('checkSession', 'Check_Session@checkSession')->name('checkSession');
//Route::get('rs_linelisting_detail', 'Check_Session@checkSession')->name('rs_linelisting_detail');
/*=====================================Layout Settings=====================================*/
Route::get('layout-{light}', function ($light) {
    session()->put('layout', $light);
    session()->get('layout');
    if ($light == 'vertical-layout') {
        return redirect()->route('pages-vertical-layout');
    }
    return redirect()->route('index');
});
Route::get('/clear-cache', function () {
    Artisan::call('config:cache');
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('view:clear');
    Artisan::call('route:clear');
    return "Cache is cleared";
})->name('clear.cache');

//Language Change
Route::get('lang/{locale}', function ($locale) {
    if (!in_array($locale, ['en', 'ur', 'de', 'es', 'fr', 'pt', 'cn', 'ae'])) {
        abort(400);
    }
    Session()->put('locale', $locale);
    Session::get('locale');
    return redirect()->back();
})->name('lang');




require __DIR__ . '/auth.php';
