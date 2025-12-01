<?php

use App\Models\SystemInfo;

if(!function_exists('getSystemInfo')) {
    function getSystemInfo($key, $default = null) {
        $record = SystemInfo::where('key', $key)->where('status', 1)->first();
        return $record ? $record->value : $default;
    }
}
