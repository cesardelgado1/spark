<?php

namespace App\Http\Controllers;

use App\Models\AuditLogs;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingsController extends Controller
{
    public function index(Request $request)
    {
        //Tab memory
        $activeTab = $request->tab ?? 'roles';
        // Search for users
        $query = User::query();

        if ($request->has('search')) {
            $query->where('email', 'like', '%' . $request->search . '%');
        }

        $users = $query->paginate(5)->withQueryString();

        // Roles
        $roles = ['Admin', 'Planner', 'Contributor', 'Assignee'];

        // All users for filter dropdown
        $allUsers = User::orderBy('email')->get();

        // Audit logs (filtered)
        $auditLogsQuery = AuditLogs::with('user')->latest();

        if ($request->has('log_search') && $request->log_search !== '') {
            $auditLogsQuery->whereHas('user', function ($query) use ($request) {
                $query->where('email', 'like', '%' . $request->log_search . '%');
            });
        }

        $auditLogs = $auditLogsQuery->take(10)->get();

        // Active sessions (using database driver)
        $sessions = DB::table('sessions')
            ->join('users', 'sessions.user_id', '=', 'users.id')
            ->select('users.email', 'sessions.ip_address', 'sessions.user_agent', 'sessions.last_activity')
            ->orderBy('sessions.last_activity', 'desc')
            ->get();

        return view('settings.index', [
            'users' => $users,
            'roles' => $roles,
            'search' => $request->search ?? '',
            'auditLogs' => $auditLogs,
            'sessions' => $sessions,
            'allUsers' => $allUsers,
            'selectedLogUser' => $request->log_user ?? 'all',
            'logSearch' => $request->log_search ?? '',
            'activeTab' => $activeTab,
        ]);
    }

    public function updateRole(Request $request, User $user)
    {

        $validated = $request->validate([
            'u_type' => 'required|in:Admin,Planner,Contributor,Assignee',
        ]);

        $user->update([
            'u_type' => $validated['u_type'],
        ]);

        AuditLogs::log("Changed role to {$validated['u_type']}", $user);

        return response()->json(['success' => true]);
    }
}
