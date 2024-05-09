<?php

use App\Helpers\Hash;
use App\Helpers\Message\Flash;
use App\Helpers\Validator;

if (!function_exists('validator')) {
    function validator()
    {
        return app()->get(Validator::class);
    }
}

if (!function_exists('hashed')) {
    function hashed()
    {
        return app()->get(Hash::class);
    }
}

if (!function_exists('flash')) {
    function flash()
    {
        return app()->get(Flash::class);
    }
}