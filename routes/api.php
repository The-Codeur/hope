<?php

use App\Support\Route;

/**
 * exemple link: http://localhost:8080/api
 * @return string hello api
 */
Route::map('GET', '/', function () {
    return 'hello api';
});
