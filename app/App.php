<?php
namespace App;

use App\Http\Core\Container;
use Meerkat\Router\CollectionRoute;
use Meerkat\Router\Router;

class App implements CollectionRoute
{
    use Router{
        Router::__construct as private __rtConstruct;
    }

    public function __construct()
    {
        $this->__rtConstruct($this->getContainer());
    }

    public function getContainer()
    {
        return Container::getInstance();
    }
}