<?php

namespace App\Helpers;

use Auth;

use App\Models\ActivityLog as MActivitylog;

/**
 * summary
 */
class Activitylog
{
    public static function newLog($action, $link = '', $description = '')
    {
        $data = [
            'user_id' => Auth::id(),
            'action' => $action,
            'link' => $link,
            'description' => $description
        ];

        $activitylog = new MActivitylog($data);
        $activitylog->save();
    }
}