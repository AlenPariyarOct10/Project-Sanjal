<?php

if (! function_exists('module_column')) {
    function module_id(string $module, string $column): string
    {
        $module = trim($module);
        $column = trim($column);

        // lowerCamelCase module
        $prefix = lcfirst($module);

        // UpperCamelCase column
        $suffix = ucfirst($column);

        return $prefix . $suffix;
    }
}
