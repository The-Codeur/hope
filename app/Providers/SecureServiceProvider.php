<?php
namespace App\Providers;

use App\Helpers\Guard\Guard;
use App\Helpers\Guard\JWToken;
use App\Helpers\Hash;
use App\Helpers\InputValidatorErrors;
use App\Helpers\Redirect;
use App\Helpers\Session;
use App\Helpers\Validator;
use App\Http\Request\Request;
use App\Support\Storage\Basket\Basket;

class SecureServiceProvider extends AbstractServiceProvider
{
    public function register()
    {

        $this->bind(Basket::class, function(){

            $sesion = $this->resolve(Session::class);

            $name = config('basket.name');

            return new Basket($name, $sesion);
        });

        $this->bind(Hash::class, fn()=> new Hash);

        $this->bind(Redirect::class, function () {

            $request = $this->resolve(Request::class);

            return new Redirect($request);
        });

        $this->bind('csrf', function(){

            $session = $this->resolve(Session::class);

            $hash = $this->resolve(Hash::class);

            return new Guard($session, $hash);
        });

        $this->bind(Validator::class, function(){

            $request = $this->resolve(Request::class);

            return new Validator($request);
        });

         $this->bind(JWToken::class, fn() => new JWToken);

        $this->bind(InputValidatorErrors::class, function () {

            $session = $this->resolve(Session::class);

            return new InputValidatorErrors($session);
        });

    }

    public function boot()
    {

        
    }
}