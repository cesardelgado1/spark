<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobController; // already there
use App\Http\Controllers\StrategicPlanController;
use App\Http\Controllers\TopicController;
use App\Http\Controllers\GoalController;
use App\Http\Controllers\ObjectiveController;
use App\Http\Controllers\IndicatorController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuditLogController;
use App\Http\Controllers\AssignObjectiveController;
use App\Http\Controllers\AssignIndicatorController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

Route::post('/logout', function () {
    Auth::logout();
    Session::flush(); // optional: kills everything
    return redirect('/');
})->name('logout');

Route::view('/', 'home');
Route::view('/planes-estrategicos', 'planes-estrategicos/index');
Route::view('/reportes', 'reportes/index');
Route::view('/configuracion', 'configuracion/index');
Route::view('/strategicplans', 'strategicplans.index');
Route::view('/topics', 'topics.index');



// Implementar en un controlador
Route::get('/strategicplans/{strategicplan}/topics', [TopicController::class, 'index'])->name('strategicplans.topics');









Route::resource('strategicplans', StrategicPlanController::class);
Route::resource('topics', TopicController::class);
Route::resource('goals', GoalController::class);
Route::resource('objectives', ObjectiveController::class);
Route::resource('indicators', IndicatorController::class);
Route::resource('users', UserController::class);


Route::get('auditlogs', [AuditLogController::class, 'index'])->name('auditlogs.index');
Route::get('auditlogs/{auditlog}', [AuditLogController::class, 'show'])->name('auditlogs.show');


Route::post('assign-objectives', [AssignObjectiveController::class, 'store'])->name('assignobjectives.store');
Route::delete('assign-objectives/{assignment}', [AssignObjectiveController::class, 'destroy'])->name('assignobjectives.destroy');

Route::post('assign-indicators', [AssignIndicatorController::class, 'store'])->name('assignindicators.store');
Route::delete('assign-indicators/{assignment}', [AssignIndicatorController::class, 'destroy'])->name('assignindicators.destroy');


require __DIR__.'/saml2.php';


//Route::get('/', function () {
//    return view('home');
//});

//Route::get('/planes-estrategicos', function () {
//    return view('planes-estrategicos.index');
//});

//Route::get('/reportes', function () {
//    return view('reportes.index');
//});
//
//Route::get('/configuracion', function () {
//    return view('configuracion.index');
//});
