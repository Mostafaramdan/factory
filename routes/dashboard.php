<?php
use Illuminate\Support\Facades\Route;

Route::ANY('/login',[App\Http\Controllers\dashboard\login::class, 'login']);
Route::get('/toggle/{table}/{column}/{id}',[App\Http\Controllers\dashboard\dashboard::class, 'toggle']);
Route::get('/dropdown/{table}/',[App\Http\Controllers\dashboard\dashboard::class, 'dropdown']);

Route::apiResource('employees',employees::class);
Route::apiResource('variable_costs',variable_costs::class);
Route::apiResource('admins',admins::class);
Route::apiResource('orders',orders::class);
Route::apiResource('returnedOrders',returnedOrders::class);
Route::apiResource('clients',clients::class);
Route::apiResource('productions',productions::class);
Route::apiResource('bills',bills::class);
Route::apiResource('matrials_types',matrials_types::class);
Route::apiResource('statistics',statistics::class);
Route::get('/permissions',[App\Http\Controllers\dashboard\dashboard::class, 'permissions']);
Route::post('/permissions/{admin}',[App\Http\Controllers\dashboard\dashboard::class, 'setPermissions']);
Route::get('/getProduction_materials',[App\Http\Controllers\dashboard\dashboard::class, 'getProduction_materials']);
Route::get('/getProductionPrice',[App\Http\Controllers\dashboard\orders::class, 'getProductionPrice']);


