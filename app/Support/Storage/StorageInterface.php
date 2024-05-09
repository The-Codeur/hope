<?php
namespace App\Support\Storage;

interface StorageInterface
{
    public function set($id, $value);

    public function get($id);

    public function all();

    public function exist($id);

    public function delete($id);

    public function clear();
}