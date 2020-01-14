<?php

namespace App\Helpers;

use Auth;

use App\Models\Config as MConfig;

/**
 * summary
 */
class Config
{
    public static function get($name, $default = '')
    {
        $mConfig = new MConfig();

        $value = $mConfig->where(['name' => $name])->get()->first();

        if ($value) {
            return $value->value;
        }

        return $default;
    }

    public static function newConfig($name, $value = '')
    {
        $mConfig = new MConfig(['name' => $name, 'value' => $value]);

        $mConfig->save();

        return $mConfig->save();
    }
}