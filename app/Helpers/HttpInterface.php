<?php
namespace App\Helpers;

interface HttpInterface
{
    public function has(string $name);

    public function get(string $name);

    public function put(string $name, $value);
}