<?php

namespace App\Observers;
use App\Models\AuditLogs;
use App\Models\Objective;

class ObjectiveObserver
{
    public function created(Objective $objective)
    {
        AuditLogs::log('Create Objective', $objective);
    }

    public function updated(Objective $objective)
    {
        AuditLogs::log('Updated Objective', $objective);
    }

    public function deleted(Objective $objective)
    {
        AuditLogs::log('Deleted Objective', $objective);
    }
}
