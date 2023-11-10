<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\ObjectController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\UserObjectController;
use App\Http\Controllers\UserObjectListSettingsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::post('/auth/login', 'App\Http\Controllers\AuthController@Login');
Route::post('/auth/reg', 'App\Http\Controllers\AuthController@Reg');
Route::post('/auth/forgot', 'App\Http\Controllers\AuthController@Forgot');
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/auth/check', 'App\Http\Controllers\AuthController@check');

    Route::post('/tariff/get', 'App\Http\Controllers\TariffController@get');
    Route::post('/tariff/add', 'App\Http\Controllers\TariffController@add');
    Route::post('/tariff/change', 'App\Http\Controllers\TariffController@change');
    Route::post('/tariff/delete', 'App\Http\Controllers\TariffController@delete');

    Route::post('/tracker/get', 'App\Http\Controllers\TrackerController@get');
    Route::post('/tracker/add', 'App\Http\Controllers\TrackerController@add');
    Route::post('/tracker/change', 'App\Http\Controllers\TrackerController@change');
    Route::post('/tracker/delete', 'App\Http\Controllers\TrackerController@delete');

    Route::post('/equipment-type/add', 'App\Http\Controllers\AdminController@addTypeEquipment');
    Route::post('/equipment-type/get', 'App\Http\Controllers\AdminController@getTypeEquipment');
    Route::post('/equipment-type/change', 'App\Http\Controllers\AdminController@changeTypeEquipment');
    Route::post('/equipment-type/delete', 'App\Http\Controllers\AdminController@deleteTypeEquipment');

    Route::post('/account/get', 'App\Http\Controllers\AccountController@get');
    Route::post('/account/init', 'App\Http\Controllers\AccountController@init');
    Route::post('/account/add', 'App\Http\Controllers\AccountController@add');
    Route::post('/account/change', 'App\Http\Controllers\AccountController@change');
    Route::post('/account/delete', 'App\Http\Controllers\AccountController@delete');
    Route::post('/account/delete', 'App\Http\Controllers\AccountController@getForDropdown');
    Route::get('account/get-for-dropdown', [AccountController::class, 'getForDropdown']);
    Route::post('/account/change-balance', [AccountController::class, 'changeBalance']);
    Route::get('/account/balance-history/{id}', [AccountController::class, 'getBalanceHistory']);

    Route::post('/user/get', 'App\Http\Controllers\UsersController@get');
    Route::post('/user/init', 'App\Http\Controllers\UsersController@init');
    Route::post('/user/add', 'App\Http\Controllers\UsersController@add');
    Route::post('/user/change', 'App\Http\Controllers\UsersController@change');
    Route::post('/user/delete', 'App\Http\Controllers\UsersController@delete');

    Route::post('/equipment/get', 'App\Http\Controllers\EquipmentController@get');
    Route::post('/equipment/init', 'App\Http\Controllers\EquipmentController@init');
    Route::post('/equipment/add', 'App\Http\Controllers\EquipmentController@add');
    Route::post('/equipment/change', 'App\Http\Controllers\EquipmentController@change');
    Route::post('/equipment/delete', 'App\Http\Controllers\EquipmentController@delete');

    Route::post('/object/get', 'App\Http\Controllers\ObjectController@get');
    Route::get('object/get-for-dropdown', [ObjectController::class, 'getForDropdown']);
    Route::post('/object/init', 'App\Http\Controllers\ObjectController@init');
    Route::post('/object/add', 'App\Http\Controllers\ObjectController@add');
    Route::post('/object/change', 'App\Http\Controllers\ObjectController@change');
    Route::post('/object/delete', 'App\Http\Controllers\ObjectController@delete');
    Route::post('/object/free_equipment', 'App\Http\Controllers\ObjectController@freeEquipment');
    Route::get('/object/user-objects', 'App\Http\Controllers\ObjectController@getUserObjects');
    Route::get('/object/user-objects-for-dropdown', [ObjectController::class, 'getUserObjectsForDropdown']);
    Route::get('/object/user-objects/{id}', [ObjectController::class, 'getUserObject']);
    Route::get(
        '/object/{imei}/common-report/messages',
        'App\Http\Controllers\ObjectController@getCommonReportMessageTabData'
    );
    Route::get(
        '/object/{imei}/common-report/statistics',
        'App\Http\Controllers\ObjectController@getCommonReportStatisticsTabData'
    );
    Route::post('user-object', [UserObjectController::class, 'store']);
    Route::patch('user-object/{id}/change-show-on-map', [UserObjectController::class, 'changeShowOnMap']);
    Route::patch('user-object/{id}/change-target-on', [UserObjectController::class, 'changeTargetOn']);
    Route::post(
        'user-object/many/change-visibility-in-list',
        [UserObjectController::class, 'multipleChangeVisibilityInList'
    ]);
    Route::post('user-object/many/change-show-on-map', [UserObjectController::class, 'multipleChangeShowOnMap']);
    Route::controller(UserObjectListSettingsController::class)->group(function () {
        Route::post('user-object-list-settings/change', 'change');
        Route::get('user-object-list-settings', 'get');
    });

    Route::get('/operation-types/get', 'App\Http\Controllers\OperationTypeController@get');


    Route::controller(PermissionController::class)->group(function () {
        Route::get('user-permission/{id}', 'get');
        Route::post('user-permission', 'add');
    });
});
