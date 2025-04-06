<?php

namespace App\Http\Controllers;

use App\Models\RoleRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RoleRequestController extends Controller
{
    public function create()
    {
        return view('roles.request');
    }

    public function store(Request $request)
    {
        $request->validate([
            'department' => 'required|string|max:255',
            'requested_role' => 'required|in:Assignee,Contributor',
        ]);

        RoleRequest::create([
            'user_id' => Auth::id(),
            'department' => $request->department,
            'requested_role' => $request->requested_role,
            'status' => 'pending', // Default status
        ]);

        return redirect()->route('roles.request')->with('success', '¡Solicitud enviada exitosamente!');
    }
    public function index()
    {
        $requests = RoleRequest::where('status', 'Pending')->with('user')->get();
        return view('roles.index', compact('requests'));
    }

    public function approve(RoleRequest $request)
    {
        DB::transaction(function () use ($request) {
            $user = $request->user;
            $user->u_type = $request->requested_role;
            $user->save();

            $request->status = 'approved';
            $request->save();
        });

        return redirect()->back()->with('success', 'Solicitud aprobada correctamente.');
    }

    public function reject(RoleRequest $request)
    {
        $request->status = 'rejected';
        $request->save();

        return redirect()->back()->with('success', 'Solicitud rechazada correctamente.');
    }
}
