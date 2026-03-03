<?php

if (!function_exists('module_id')) {
    /**
     * Generate a camelCase element ID from module + column names.
     * Example: module_id('User', 'modal') => 'userModal'
     */
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
