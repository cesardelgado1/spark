<?php

use App\Http\Controllers\SettingsController;
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
use App\Http\Controllers\ExportController;

Route::post('/logout', function () {
    Auth::logout();
    Session::flush(); // optional: kills everything
    return redirect('/');
})->name('logout');

Route::view('/', 'home');
Route::view('/planes-estrategicos', 'planes-estrategicos/index');
Route::view('/reportes', 'reportes/index');
Route::view('/strategicplans', 'strategicplans.index');
Route::view('/topics', 'topics.index');



// Implementar en un controlador
Route::get('/strategicplans/{strategicplan}/topics', [TopicController::class, 'showTopics'])->name('strategicplans.topics');

Route::get('/topics/{topic}/goals', [GoalController::class, 'showGoals'])->name('topics.goals');

Route::get('/goals/{goal}/objectives', [ObjectiveController::class, 'showObjectives'])->name('goals.objectives');

Route::get('/objectives/{objective}/indicators', [IndicatorController::class, 'showIndicators'])->name('objectives.indicators');

// ESTAS RUTAS SON JUNTO CON EL STRATEGIC PLAN, CREO QUE ESTA ES LA FORMA.

// TOPICS
Route::middleware(['auth', 'isPlanner'])->group(function () {
    Route::get('/strategicplans/{strategicplan}/topics/create', [TopicController::class, 'create'])->name('topics.create');
    Route::post('/strategicplans/{strategicplan}/topics', [TopicController::class, 'store'])->name('topics.store');
    Route::delete('/topics/bulk-delete', [TopicController::class, 'bulkDelete'])->name('topics.bulkDelete');
    Route::get('/topics/{topic}/edit', [TopicController::class, 'edit'])->name('topics.edit');
    Route::put('/topics/{topic}', [TopicController::class, 'update'])->name('topics.update');
    Route::get('/topics/{strategicplan}', [TopicController::class, 'index'])->name('topics.index');
});

//GOALS
Route::middleware(['auth', 'isPlanner'])->group(function () {
    Route::get('/topics/{topic}/goals/create', [GoalController::class, 'create'])->name('goals.create');
    Route::post('/topics/{topic}/goals', [GoalController::class, 'store'])->name('goals.store');
    Route::delete('/goals/bulk-delete', [GoalController::class, 'bulkDelete'])->name('goals.bulkDelete');
    Route::get('/goals/{goal}/edit', [GoalController::class, 'edit'])->name('goals.edit');
    Route::put('/goals/{goal}', [GoalController::class, 'update'])->name('goals.update');
    Route::get('/topics/{topic}/goals', [GoalController::class, 'index'])->name('topics.goals');
});

// OBJECTIVES
Route::middleware(['auth', 'isPlanner'])->group(function () {
    Route::get('/goals/{goal}/objectives/create', [ObjectiveController::class, 'create'])->name('objectives.create');
    Route::post('/goals/{goal}/objectives', [ObjectiveController::class, 'store'])->name('objectives.store');
    Route::delete('/objectives/bulk-delete', [ObjectiveController::class, 'bulkDelete'])->name('objectives.bulkDelete');
    Route::get('/objectives/{objective}/edit', [ObjectiveController::class, 'edit'])->name('objectives.edit');
    Route::put('/objectives/{objective}', [ObjectiveController::class, 'update'])->name('objectives.update');
    Route::get('/goals/{goal}/objectives', [ObjectiveController::class, 'index'])->name('goals.objectives');

});

// INDICATORS
Route::middleware(['auth', 'isPlanner'])->group(function () {
    Route::get('/objectives/{objective}/indicators/create', [IndicatorController::class, 'create'])->name('indicators.create');
    Route::post('/objectives/{objective}/indicators', [IndicatorController::class, 'store'])->name('indicators.store');
    Route::delete('/indicators/bulk-delete', [IndicatorController::class, 'bulkDelete'])->name('indicators.bulkDelete');
    Route::get('/indicators/{indicator}/edit', [IndicatorController::class, 'edit'])->name('indicators.edit');
    Route::put('/indicators/{indicator}', [IndicatorController::class, 'update'])->name('indicators.update');
    Route::get('/objectives/{objective}/indicators', [IndicatorController::class, 'index'])->name('objectives.indicators');
});

//ADMIN

Route::middleware(['auth', 'isAdmin'])->group(function () {
    Route::get('/configuracion', [SettingsController::class, 'index'])->name('settings.index');
    Route::patch('/configuracion/role-usuario/{user}', [SettingsController::class, 'updateRole'])->name('settings.updateRole');
});


# CAUTION THESE WILL PROBABLY GENEATE SOME CONFLICTS WILL REMOVE SOON!!!
Route::resource('strategicplans', StrategicPlanController::class);
#Route::resource('topics', TopicController::class);
#Route::resource('goals', GoalController::class);
#Route::resource('objectives', ObjectiveController::class);
#Route::resource('indicators', IndicatorController::class);
Route::resource('users', UserController::class);


Route::get('auditlogs', [AuditLogController::class, 'index'])->name('auditlogs.index');
Route::get('auditlogs/{auditlog}', [AuditLogController::class, 'show'])->name('auditlogs.show');


Route::post('assign-objectives', [AssignObjectiveController::class, 'store'])->name('assignobjectives.store');
Route::delete('assign-objectives/{assignment}', [AssignObjectiveController::class, 'destroy'])->name('assignobjectives.destroy');

Route::post('assign-indicators', [AssignIndicatorController::class, 'store'])->name('assignindicators.store');
Route::delete('assign-indicators/{assignment}', [AssignIndicatorController::class, 'destroy'])->name('assignindicators.destroy');


Route::get('/export', [ExportController::class, 'export']);



require __DIR__.'/saml2.php';
