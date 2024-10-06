<?php

use App\Models\Config;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;

/**
 * Fetch config data by key
 * 
 * @param  $key
 * 
 * @return mixed
 */
function settings($key)
{
    static $config;

    if (is_null($config)) {
        $config = Cache::remember('config', 24 * 60, function () {
            return Config::pluck('value', 'key')->toArray();
        });
    }

    return (is_array($key)) ? Arr::only($config, $key) : $config[$key];
}

/**
 * Update env file
 * 
 * @param  $key means the key of env file
 * @param  $value associated with the key
 * 
 * @return mixed
 */
function updateEnv($key, $value)
{
    $path = app()->environmentFilePath();

    $escaped = preg_quote('='.env($key), '/');

    file_put_contents($path, preg_replace(
        "/^{$key}{$escaped}/m",
        "{$key}={$value}",
        file_get_contents($path)
    ));
}