<?php

use App\Models\ActivityLog;

function addLog($user_id, $action, $description = null)
{
    ActivityLog::create([
        'user_id' => $user_id,
        'action' => $action,
        'description' => $description,
    ]);
}
