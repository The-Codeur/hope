<?php
namespace App\Helpers\Message;

use App\Helpers\Session;

class Flash
{
    public function __construct(Private Session $session)
    {
        
    }

    public function has(string $name)
    {
        return $this->session->has($name);
    }

    public function get(string $name)
    {
        $message = $this->session->get($name);

        $this->session->delete($name);

        return $message;
    }

    public function put(string $name, $value)
    {
        $this->session->put($name, $value);
    }
}