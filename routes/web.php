<?php

use App\Http\Controllers\RoleRequestController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\StrategicPlanController;
use App\Http\Controllers\TaskController;
use App\Models\StrategicPlan;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobController; // already there
use App\Http\Controllers\HomeController;
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
use App\Http\Controllers\IndicatorEntryController;


Route::post('/logout', function () {
    Auth::logout();
    Session::flush(); // optional: kills everything
    return redirect('/');
})->name('logout');

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::view('/planes-estrategicos', 'planes-estrategicos/index');
Route::view('/reportes', 'reportes/index');
Route::view('/topics', 'topics.index');



// Implementar en un controlador
Route::get('/strategicplans/{strategicplan}/topics', [TopicController::class, 'showTopics'])->name('strategicplans.topics');

Route::get('/topics/{topic}/goals', [GoalController::class, 'showGoals'])->name('topics.goals');

Route::get('/goals/{goal}/objectives', [ObjectiveController::class, 'showObjectives'])->name('goals.objectives');

Route::get('/objectives/{objective}/indicators', [IndicatorController::class, 'showIndicators'])->name('objectives.indicators');

// ESTAS RUTAS SON JUNTO CON EL STRATEGIC PLAN, CREO QUE ESTA ES LA FORMA.

// STRATEGIC PLANS
Route::delete('/strategicplans/bulk-delete', [StrategicPlanController::class, 'bulkDelete'])->name('strategicplans.bulkDelete');


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
    Route::put('/indicators/{indicator}/update-value', [IndicatorController::class, 'updateValue'])->name('indicators.updateValue');
});

//ADMIN
Route::middleware(['auth', 'adminOrPlanner'])->group(function () {
    Route::get('/configuracion', [SettingsController::class, 'index'])->name('settings.index');
    Route::patch('/configuracion/role-usuario/{user}', [SettingsController::class, 'updateRole'])->name('settings.updateRole');
});

// ASSIGNMENT
Route::get('/tareas', [\App\Http\Controllers\TaskController::class, 'index'])->name('tasks.index');
Route::get('/objectives/{objective}/assign', [AssignObjectiveController::class, 'showAssigneeForm'])->name('roles.assignView');
Route::post('/objectives/{objective}/assign', [AssignObjectiveController::class, 'assignToAssignee'])->name('roles.assign');
Route::get('/objectives/{objective}/indicators/fill', [IndicatorEntryController::class, 'showForEntry'])->name('indicators.fill');
Route::post('/indicators/update-values', [IndicatorEntryController::class, 'updateValues'])->name('indicators.updateValues');
Route::get('/objectives/{objective}/assigned-users', [ObjectiveController::class, 'getAssignedContributors']);
Route::get('/tareas/{objective}/assign', [TaskController::class, 'assignAssigneesForm'])->name('tasks.assignView');
Route::post('/tareas/assign', [TaskController::class, 'assignAssigneesStore'])->name('tasks.assignStore');
Route::delete('/assignments/{assignment}', [AssignObjectiveController::class, 'destroy'])->name('roles.destroy');

//ROLE REQUESTS
Route::get('/solicitar-acceso', [RoleRequestController::class, 'create'])->name('roles.request');
Route::post('/solicitar-acceso', [RoleRequestController::class, 'store'])->name('roles.request.submit');
Route::middleware(['auth', 'isPlanner'])->group(function () {
    Route::get('/roles/requests', [RoleRequestController::class, 'index'])->name('roles.requests.index');
    Route::post('/roles/requests/{request}/approve', [RoleRequestController::class, 'approve'])->name('roles.requests.approve');
    Route::post('/roles/requests/{request}/reject', [RoleRequestController::class, 'reject'])->name('roles.requests.reject');
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

Route::get('/goals/{goal}/assign', [ObjectiveController::class, 'showAssignForm'])->name('objective.assign.view');
Route::post('/assign-objectives', [AssignObjectiveController::class, 'store'])->name('assignobjectives.store');
#Route::post('assign-objectives', [AssignObjectiveController::class, 'store'])->name('assignobjectives.store');
#Route::delete('assign-objectives/{assignment}', [AssignObjectiveController::class, 'destroy'])->name('assignobjectives.destroy');

Route::post('assign-indicators', [AssignIndicatorController::class, 'store'])->name('assignindicators.store');
Route::delete('assign-indicators/{assignment}', [AssignIndicatorController::class, 'destroy'])->name('assignindicators.destroy');


Route::post('/export', [ExportController::class, 'export'])->name('export');
Route::get('/reportes', [ExportController::class, 'getAllSP'])->name('reportes.index');
Route::get('/reportes/sp/{sp_id}/fys', [ExportController::class, 'getFYsForSP']);
Route::get('/reportes/{sp_id}/{fy}/topics', [ExportController::class, 'getTopicsForSPandFY']);
Route::get('/reportes/topics/{topic_id}/goals/{fy}', [ExportController::class, 'getGoalsForTopicAndFY']);
Route::get('/reportes/goals/{goal_id}/objectives/{fy}', [ExportController::class, 'getObjectivesForGoalAndFY']);




require __DIR__.'/saml2.php';
