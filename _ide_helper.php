<?php

/**
 * IDE Helper for llm-provider-ollama package
 * 
 * This file provides type hints for Laravel helper functions
 * to eliminate false positives in IDE linting.
 * 
 * DO NOT INCLUDE THIS FILE IN PRODUCTION.
 */

if (!function_exists('env')) {
    function env($key, $default = null) {}
}

if (!function_exists('config')) {
    function config($key = null, $default = null) {}
}

if (!function_exists('config_path')) {
    function config_path($path = '') {}
}

if (!function_exists('resource_path')) {
    function resource_path($path = '') {}
}

if (!function_exists('public_path')) {
    function public_path($path = '') {}
}

if (!function_exists('storage_path')) {
    function storage_path($path = '') {}
}

if (!function_exists('view')) {
    function view($view = null, $data = [], $mergeData = []) {}
}

if (!function_exists('redirect')) {
    function redirect($to = null, $status = 302, $headers = [], $secure = null) {}
}

if (!function_exists('auth')) {
    function auth($guard = null) {}
}

if (!function_exists('collect')) {
    function collect($value = null) {}
}

if (!function_exists('compact')) {
    function compact(...$vars) {}
}

if (!function_exists('route')) {
    function route($name, $parameters = [], $absolute = true) {}
}
