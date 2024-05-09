<?php
namespace App\Views\Extensions;

use App\Helpers\Session;
use App\Http\Request\Request;
use Twig\Extension\GlobalsInterface;
use App\Helpers\InputValidatorErrors;
use App\Helpers\Message\Flash;
use Twig\Extension\AbstractExtension;
use App\Support\Storage\Basket\Basket;

class TwigGlobalExtension extends AbstractExtension implements GlobalsInterface
{

    private $container;

    public function __construct()
    {
        $this->container = app();
    }
    public function getGlobals(): array
    {
        return [
            'request' => $this->request(),

            'session' => $this->session(),

            'flash' => $this->flash(),

            'csrf_field' => $this->csrf_field(),

            'csrf' => $this->csrf(),

            'errors' => $this->errors(),

            'basket' => $this->basket()
        ];
    }

    public function request()
    {
        return $this->container->get(Request::class);
    }

    public function session()
    {
        return $this->container->get(Session::class);
    }

    public function flash()
    {
        return $this->container->get(Flash::class);
    }

    public function csrf()
    {
        $csrf = $this->container->get('csrf');

        return [
            'name'  => $csrf->getName(),
            'value' => $csrf->getValue()
        ];
    }

    public function csrf_field()
    {
        $csrf = $this->container->get('csrf');

        return '
            <input type="hidden" name="'.$csrf->getName().'" value="'.$csrf->getValue().'"/>
        ';
    }

    public function basket()
    {
        return $this->container->get(Basket::class);
    }

    public function errors()
    {
        return $this->container->get(InputValidatorErrors::class);
    }
}