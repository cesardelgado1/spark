<?php

namespace App\Observers;
use App\Models\AuditLogs;
use App\Models\Goal;

class GoalObserver
{
    public function created(Goal $goal)
    {
        AuditLogs::log('Created Goal', $goal);
    }

    public function updated(Goal $goal)
    {
        AuditLogs::log('Updated Goal', $goal);
    }

    public function deleted(Goal $goal)
    {
        AuditLogs::log('Deleted Goal', $goal);
    }
}
