<?php
namespace App\Helpers\Guard;

use App\Helpers\Hash;
use App\Helpers\Session;

class Guard
{

    public function __construct(protected Session $session, protected Hash $hash)
    {
    }

    public function has()
    {
        $name = $this->getName();

        return $this->session->has($name);
    }

    public function check(string $token)
    {
        if($this->has() && $token === $this->getValue())
        {
            return true;
        }

        return false;
    }

    public function getName()
    {
        $name = config('guard.name');

        return $name;
    }

    public function getValue()
    {
        $name = $this->getName();

        return $this->session->get($name);
    }

    public function generate()
    {
        $name = $this->getName();

        $hash = $this->hash->unique();

        $this->session->put($name, $hash);
    }
}