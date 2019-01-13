<?php

namespace Larams\Cms;

use Illuminate\Database\Eloquent\Model;

class ActionLog extends Model
{
    protected $fillable = ['user_id', 'related_id', 'type', 'message', 'data'];

    protected $table = 'actions_log';

    public static function log($relatedId, $type, $message, $data = null)
    {
        if (!config('larams.admin.log_admin_actions')) {
            return null;
        }

        return static::create([
            'user_id' => auth()->user()->id,
            'related_id' => $relatedId,
            'type' => $type,
            'message' => $message,
            'data' => !empty($data) ? json_encode($data) : null
        ]);
    }

}
