<?php
namespace Boot\Manager;

use App\App;

abstract class Kernel
{
    protected array $bootstrap = [];

    public function __construct(protected App &$app)
    {
        $app->getContainer()->set(self::class, fn() => $this);

        Bootstrapper::handle($app, $this->bootstrap);
    }

    public function getApplication()
    {
        return $this->app;
    }

    public static function bootstrap(App $app)
    {
        return new static($app);
    }
}