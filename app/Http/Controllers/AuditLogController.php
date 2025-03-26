<?php

namespace App\Http\Controllers;

use App\Models\AuditLogs;
use Illuminate\Http\Request;

class AuditLogController extends Controller
{
    public function index()
    {
        $auditlogs = AuditLogs::latest()->simplePaginate(10);
        return view('auditlogs.index', compact('auditlogs'));
    }

    public function show(AuditLogs $auditlog)
    {
        return view('auditlogs.show', compact('auditlog'));
    }
}
