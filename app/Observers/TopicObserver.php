<?php

namespace App\Observers;
use App\Models\AuditLogs;
use App\Models\Topic;

class TopicObserver
{
    public function created(Topic $topic)
    {
        AuditLogs::log('Created Topic', $topic->t_id);
    }

    public function updated(Topic $topic)
    {
        AuditLogs::log('Updated Topic', $topic->t_id);
    }

    public function deleted(Topic $topic)
    {
        AuditLogs::log('Deleted Topic', $topic->t_id);
    }
}
