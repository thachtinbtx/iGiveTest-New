<?php
/**
 * Polyfills for PHP 8.2 compatibility
 * Restores functions removed in PHP 7.x/8.x to allow legacy libraries (Smarty 2.x, ADODB) to function.
 */

// Polyfill for each() - Removed in PHP 8.0
if (!function_exists('each')) {
    function each(&$array) {
        if (!is_array($array) && !is_object($array)) {
            return false;
        }
        $key = key($array);
        if ($key === null) {
            return false;
        }
        $value = current($array);
        $result = array(
            1 => $value,
            'value' => $value,
            0 => $key,
            'key' => $key,
        );
        next($array);
        return $result;
    }
}

// Polyfill for get_magic_quotes_gpc() - Removed in PHP 8.0
if (!function_exists('get_magic_quotes_gpc')) {
    function get_magic_quotes_gpc() {
        return false;
    }
}

// Polyfill for get_magic_quotes_runtime() - Removed in PHP 8.0
if (!function_exists('get_magic_quotes_runtime')) {
    function get_magic_quotes_runtime() {
        return false;
    }
}

// Polyfill for set_magic_quotes_runtime() - Removed in PHP 8.0
if (!function_exists('set_magic_quotes_runtime')) {
    function set_magic_quotes_runtime($new_setting) {
        return false;
    }
}

// Polyfill for create_function() - Removed in PHP 8.0
// WARNING: usage of eval() is insecure, but necessary for legacy Smarty 2.x support
if (!function_exists('create_function')) {
    function create_function($args, $code) {
        return eval("return function($args) { $code };");
    }
}

// Polyfill for mysql_connect and related functions if absolutely necessary
// Note: It is HIGHLY recommended to switch to mysqli or PDO. 
// This is just a stub to prevent fatal errors on load, but functionality will fail if not switched.
if (!function_exists('mysql_connect')) {
    function mysql_connect($server, $username, $password) {
        trigger_error("mysql_connect is removed. Please use mysqli_connect.", E_USER_ERROR);
        return false;
    }
}
?>
