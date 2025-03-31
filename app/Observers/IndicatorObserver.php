<?php

namespace App\Observers;
use App\Models\AuditLogs;
use App\Models\Indicator;

class IndicatorObserver
{
    public function created(Indicator $indicator)
    {
        AuditLogs::log('Created Indicator', $indicator);
    }

    public function updated(Indicator $indicator)
    {
        AuditLogs::log('Updated Indicator', $indicator);
    }

    public function deleted(Indicator $indicator)
    {
        AuditLogs::log('Deleted Indicator', $indicator);
    }
}
