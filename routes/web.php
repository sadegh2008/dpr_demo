<?php

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
    return view('welcome');
});

Auth::routes();

Route::prefix('dashboard')->group(function () {
    Route::get('/', 'TicketController@index');
});

// User Routes
Route::prefix('dashboard/users')->group(function () {
    // we can use resource for CRUD
    Route::get('/list', ['uses' => 'UserController@list', 'as' => 'users.list']);
    Route::get('/', ['uses' => 'UserController@index', 'as' => 'users.index']);
    Route::get('/create', ['uses' => 'UserController@create', 'as' => 'users.create']);
    Route::get('/{user_id}', ['uses' => 'UserController@show', 'as' => 'users.show']);
    Route::get('edit/{user_id}', ['uses' => 'UserController@edit', 'as' => 'users.edit']);
    Route::post('/{user_id}', ['uses' => 'UserController@store', 'as' => 'users.store']);
    Route::patch('/{user_id}', ['uses' => 'UserController@update', 'as' => 'users.update']);
    Route::delete('/{user_id}', ['uses' => 'UserController@destroy', 'as' => 'users.destroy']);
});

// Ticket Routes
Route::prefix('dashboard/tickets')->middleware(['auth'])->group(function () {
    // we can use resource for CRUD
    Route::get('/', ['uses' => 'TicketController@index', 'as' => 'tickets.index']);
    Route::get('/create', ['uses' => 'TicketController@create', 'as' => 'tickets.create']);
    Route::put('/{ticket_id}/assign', ['uses' => 'TicketController@assignUser', 'as' => 'tickets.assign_user']);
    Route::get('/wait_for_destroy', ['uses' => 'TicketController@waitForDestroy', 'as' => 'tickets.wait_for_destroy']);
    Route::get('/{ticket_id}', ['uses' => 'TicketController@show', 'middleware' => ['permission:view_ticket'], 'as' => 'tickets.show']);
    Route::get('/edit/{ticket_id}', ['uses' => 'TicketController@edit', 'middleware' => ['permission:view_ticket'], 'as' => 'tickets.edit']);
    Route::post('/{ticket_id}', ['uses' => 'TicketController@store', 'middleware' => ['permission:create_ticket'], 'as' => 'tickets.store']);
    Route::patch('/{ticket_id}', ['uses' => 'TicketController@update', 'middleware' => ['permission:update_ticket'], 'as' => 'tickets.update']);
    Route::delete('/{ticket_id}', ['uses' => 'TicketController@destroy', 'middleware' => ['permission:delete_ticket|confirm_delete_ticket'], 'as' => 'tickets.destroy']);
});
