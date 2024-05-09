<?php
namespace App\Http\Core;

use App\Http\Request\Response;
use Psr\Container\ContainerInterface;

class BaseController
{
    public function __construct(protected ContainerInterface $container)
    {
        
    }

    public function __get($property)
    {
        if($this->container->get($property))
        {
            return $this->container->get($property);
        }
    }


    protected function render(Response $response, string $view, array $data = [])
    {
        return view($response, $view, $data);
    }

    protected function json($content, int $statusCode = 200, array $headers = [])
    {
        $response = $this->container->get(Response::class);

        return $response->json($content, $statusCode, $headers);
    }
}