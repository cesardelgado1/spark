<?php

namespace App\Observers;

use App\Models\AuditLogs;
use App\Models\StrategicPlan;

class StrategicPlanObserver
{
    public function created(StrategicPlan $plan)
    {
        AuditLogs::log('Created Strategic Plan', $plan);
    }

    public function updated(StrategicPlan $plan)
    {
        AuditLogs::log('Updated Strategic Plan', $plan);
    }

    public function deleted(StrategicPlan $plan)
    {
        AuditLogs::log('Deleted Strategic Plan', $plan);
    }
}
