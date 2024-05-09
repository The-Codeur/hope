<?php
namespace App\Providers;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container;


class DatabaseServiceProvider extends AbstractServiceProvider
{
    public function register()
    {
        $mode = config('default');

        $connection = config('connections.'. env('DB_DRIVER', $mode));

        $capsule = new Capsule();

        $capsule->addConnection($connection);

        $capsule->setEventDispatcher(new Dispatcher(new Container));

        $capsule->setAsGlobal();

        $capsule->bootEloquent();

        $this->bind(Capsule::class, fn() => $capsule);
    }

    public function boot()
    {
    }
}