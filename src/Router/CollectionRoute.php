<?php
namespace Meerkat\Router;

interface CollectionRoute
{
    public function get(string $path, $callback);

    public function post(string $path, $callback);

    public function put(string $path, $callback);

    public function patch(string $path, $callback);

    public function delete(string $path, $callback);

    public function group(string $prefix, callable $callback);
}