<?php
namespace App\Helpers;

class Hash
{
    public function make(string $content, ?string $salt = null)
    {
        return hash('sha256', $content.$salt);
    }

    public function password(string $password, $type = PASSWORD_BCRYPT, array $options = ['cost' => 12])
    {
        return password_hash($password, $type, $options);
    }

    public function verify(string $password, string $hash)
    {
        return password_verify($password, $hash);
    }

    public function salt(int $length)
    {
        $alphanum = 'azertyuiopqsdfghjklmwxcvbnAZERTYUIOPQSDFGHJKLMWXCVBN9874563210';

        $sufl = str_shuffle(str_repeat($alphanum, $length));

        $salt = substr($sufl, 0, $length);

        return $salt;
    }

    public function unique()
    {
        return $this->make(uniqid('', true));
    }

    public function reduce(int $length)
    {
        return substr($this->unique(), 0, $length);
    }
}