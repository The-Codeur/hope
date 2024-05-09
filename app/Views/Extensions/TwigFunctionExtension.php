<?php
namespace App\Views\Extensions;

use App\Http\Request\Request;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class TwigFunctionExtension extends AbstractExtension
{
    private $container;

    public function __construct()
    {
        $this->container = app();
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('route', [$this, 'route']),
            new TwigFunction('asset', [$this, 'asset']),
            new TwigFunction('old', [$this, 'old']),
            new TwigFunction('method', [$this, 'method'], ['is_safe' => ['html']])
        ];
    }

    public function route(string $name, array $params = [])
    {
        return route($name, $params);
    }

    public function asset(string $path)
    {
        return SCRIPT_PATH.trim($path, DS);
    }

    public function old(string $name)
    {
        $request = $this->container->get(Request::class);

        if(!$request->hasParam($name))
        {
            return '';
        }

        return $request->getParam($name);
    }

    public function method(string $method)
    {
        return <<< EOT
            <input type="hidden" name="_method" value="$method">
        EOT;
    }
}