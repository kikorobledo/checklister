<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\User\ChecklistController as C;
use App\Http\Controllers\Admin\ChecklistController;
use App\Http\Controllers\Admin\ChecklistGroupController;
use App\Http\Controllers\Admin\ImageController;
use App\Http\Controllers\Admin\TaskController;
use App\Http\Controllers\Admin\UserController;

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

Route::redirect('/', 'welcome');

Auth::routes();

Route::group(['middleware' => ['auth', 'last_action_timestamp']], function(){

    Route::get('welcome', [PageController::class, 'welcome'])->name('welcome');

    Route::get('checklists/{checklist}', [\App\Http\Controllers\User\ChecklistController::class, 'show'])->name('users.checklists.show');

    Route::get('taskslist/{list_type}', [C::class, 'taskList'])->name('user.tasklist');

    Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'is_admin'], function(){

        Route::resource('pages', PageController::class)->only(['edit', 'update']);

        Route::resource('checklist_groups', ChecklistGroupController::class);

        Route::resource('checklist_groups.checklists', ChecklistController::class);

        Route::resource('checklists.tasks', TaskController::class);

        Route::get('users', [UserController::class, 'index'])->name('users.index');

        Route::post('images', [ImageController::class, 'store'])->name('images.store');

    });

});
