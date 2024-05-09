<?php
namespace App\Helpers;

class Cookie
{
    public function has(string $name)
    {
        return isset($_COOKIE[$name]);
    }

    public function get(string $name)
    {
        if($this->has($name))
        {
            return $_COOKIE[$name];
        }
    }

    public function put(string $name, $value, int $expires)
    {
        $options = [
            'expires'  => time() + $expires,
            'path'     => DS,
            'secure'   => true,
            'httponly' => true,
            'samesite' => 'Lax'
        ];

        if(setcookie($name, $value, $options))
        {
            return true;
        }

        return false;
    }

    public function destroy(string $name)
    {
        return $this->put($name, "", time()-1);
    }
}