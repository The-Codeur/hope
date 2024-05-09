<?php
namespace App\Helpers;

class Session implements HttpInterface
{
    public function has(string $name)
    {
        return (isset($_SESSION[$name])) ? true : false;
    }

    public function notEmpty(string $name)
    {
        return !empty($_SESSION[$name]);
    }

    public function get(string $name)
    {
        if($this->has($name))
        {
            return $_SESSION[$name];
        }

        return null;
    }

    public function put(string $name, $value)
    {
        $_SESSION[$name] = $value;
    }

    public function all()
    {
        return $_SESSION;
    }

    public function delete(string $name)
    {
        if($this->has($name))
        {
            unset($_SESSION[$name]);
        }
    }

    public function destroy()
    {
        unset($_SESSION);
    }
}
