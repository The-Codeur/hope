<?php
namespace Command;

class DeberyHelper
{

public static function createModel(string $name)
{
    return "<?php 
namespace App\Models;

use Illuminate\\Database\\Eloquent\\Model;

class ".ucfirst($name)." extends Model
{

}
";
}

public static function createController(string $name)
{

    return "<?php 
namespace App\\Http\\Controllers;

use App\\Http\\Core\\BaseController as Controller;

class ".ucfirst($name)." extends Controller
{

}
";
}

public static function createMiddleware(string $name)
{

    return "<?php 
namespace App\\Http\\Middlewares;

use App\\Http\\Request\\Request;
use App\\Http\\Request\\Response;
use App\\Http\\Core\\AbstractMiddleware;

class ".ucfirst($name). " extends AbstractMiddleware
{
    public function __invoke(Request \$request, Response \$response, callable \$next)
    {

        return \$next(\$request, \$response);
    }
}
";
}

public static function createEvent(string $name)
{

    return "<?php 
namespace App\\Events;

use App\\Helpers\\Events\\EventListenerInterface;

class ".ucfirst($name)." implements EventListenerInterface
{
    public function getEvents(): array
    {
        return [

        ];
    }
}
";
}

public static function createprovider(string $name)
{

        return "<?php 
namespace App\Providers;

class " . ucfirst($name) . " extends AbstractServiceProvider
{
    public function register()
    {

    }

    public function boot()
    {
        
    }
}
";
}
}
