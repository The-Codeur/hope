<?php

namespace App\Providers;

class SessionStartServiceProvider extends AbstractServiceProvider
{
    public function register()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
    }

    public function boot()
    {
    }
}
