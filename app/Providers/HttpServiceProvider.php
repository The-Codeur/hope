<?php
namespace App\Providers;

use App\Helpers\Cookie;
use App\Helpers\Events\Event;
use App\Helpers\Message\Flash;
use App\Helpers\Session;
use App\Http\Request\Request;
use App\Http\Request\Response;
use Intervention\Image\ImageManager;

class HttpServiceProvider extends AbstractServiceProvider
{
    public function register()
    {
        $this->bind(Request::class, fn()=> Request::fromGlobal());

        $this->bind(Response::class, fn () => new Response());

        $this->bind(Session::class, fn () => new Session);

        $this->bind(Cookie::class, fn () => new Cookie);

        $this->bind(Event::class, fn () => new Event);

        $this->bind(Flash::class, function(){

            $session = $this->resolve(Session::class);

            return new Flash($session);
        });

        $this->bind(ImageManager::class, fn () => new ImageManager());

    }

    public function boot()
    {
        define('SCRIPT_PATH', dirname($this->resolve(Request::class)->getScript()));
    }
}