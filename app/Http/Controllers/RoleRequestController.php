<?php

namespace App\Http\Controllers;

use App\Models\RoleRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleRequestController extends Controller
{
    /**
     * Displays the role request form for the current user.
     *
     * If the user already submitted a request, shows their latest one.
     */
    public function create()
    {
        $latestRequest = RoleRequest::where('user_id', Auth::id())
            ->latest()
            ->first();

        return view('roles.request', [
            'existingRequest' => $latestRequest
        ]);
    }

    /**
     * Stores a new role request submitted by the user.
     */
    public function store(Request $request)
    {
        $request->validate([
            'department' => 'required|string|max:255',
            'requested_role' => 'required|in:Assignee,Contributor,Planner',
        ]);

        RoleRequest::create([
            'user_id' => Auth::id(),
            'department' => $request->department,
            'requested_role' => $request->requested_role,
            'status' => 'pending',
        ]);

        return redirect()->route('roles.request')->with('success', '¡Solicitud enviada exitosamente!');
    }

    /**
     * Allows a user to update their own pending role request.
     *
     * If the request isn't theirs or has already been processed, it is blocked.
     */
    public function update(Request $request, RoleRequest $roleRequest)
    {
        if ($roleRequest->user_id !== Auth::id() && $roleRequest->status !== 'pending') {
            abort(403, 'No autorizado para editar esta solicitud.');
        }

        $request->validate([
            'department' => 'required|string|max:255',
            'requested_role' => 'required|in:Assignee,Contributor,Planner',
        ]);

        $roleRequest->update([
            'department' => $request->department,
            'requested_role' => $request->requested_role,
        ]);

        return redirect()->route('roles.request')->with('success', 'Solicitud actualizada correctamente.');
    }

    /**
     * Shows a list of all pending role requests for review by admins.
     */
    public function index()
    {
        $requests = RoleRequest::where('status', 'pending')->with('user')->get();
        return view('roles.index', compact('requests'));
    }

    /**
     * Approves a single role request and updates the user's role.
     */
    public function approve(RoleRequest $request)
    {
        $user = $request->user;

        if (!$user) {
            return redirect()->back()->with('error', 'No se pudo encontrar el usuario para esta solicitud.');
        }

        $user->u_type = $request->requested_role;
        $user->save();

        $request->status = 'approved';
        $request->save();

        return redirect()->back()->with('success', 'Rol aprobado exitosamente.');
    }

    /**
     * Rejects a single role request.
     */
    public function reject(RoleRequest $request)
    {
        $request->status = 'rejected';
        $request->save();

        return redirect()->back()->with('success', 'Solicitud rechazada correctamente.');
    }

    /**
     * Approves multiple selected role requests at once.
     *
     * Updates each user's role and marks their request as approved.
     */
    public function approveBulk(Request $request)
    {
        $ids = $request->input('selected_requests', []);

        foreach ($ids as $id) {
            $req = RoleRequest::with('user')->findOrFail($id);

            if ($req->user) {
                $req->user->u_type = $req->requested_role;
                $req->user->save();
            }

            $req->status = 'approved';
            $req->save();
        }

        return redirect()->back()->with('success', 'Solicitudes aprobadas correctamente.');
    }

    /**
     * Rejects multiple selected role requests at once.
     */
    public function bulkReject(Request $request)
    {
        $ids = $request->input('selected_requests', []);

        foreach ($ids as $id) {
            $req = RoleRequest::findOrFail($id);
            $req->status = 'rejected';
            $req->save();
        }

        return redirect()->back()->with('success', 'Solicitudes rechazadas correctamente.');
    }
}
