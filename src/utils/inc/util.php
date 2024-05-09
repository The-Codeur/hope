<?php

$dotenv = Dotenv\Dotenv::createImmutable(BASE_PATH);

$dotenv->load();

$files = glob(dirname(__DIR__).'/*.php' ?: []);

array_map(fn($file) => require_once $file, $files);

