<?php

namespace App\Http\Controllers;

use App\Models\AuditLogs;
use Illuminate\Http\Request;

class AuditLogController extends Controller
{
    /**
     * Displays a paginated list of recent audit log entries.
     *
     * Retrieves the latest audit logs and passes them to the index view.
     */
    public function index()
    {
        $auditlogs = AuditLogs::latest()->simplePaginate(10);
        return view('auditlogs.index', compact('auditlogs'));
    }

    /**
     * Displays the details of a specific audit log entry.
     *
     * Loads the selected audit log and passes it to the detail view.
     */
    public function show(AuditLogs $auditlog)
    {
        return view('auditlogs.show', compact('auditlog'));
    }
}
