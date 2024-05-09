<?php
namespace App\Http\Request;

use App\Helpers\Cookie;
use App\Helpers\Session;

class Request
{
    public function __construct(
        private readonly array $query,
        private readonly array $body,
        private readonly array $session,
        private readonly array $cookie,
        private readonly array $server,
        private readonly array $files,
    )
    {
        
    }

    public static function fromGlobal()
    {
        return new self(
            $_GET,
            $_POST,
            $_SESSION,
            $_COOKIE,
            $_SERVER,
            $_FILES
        );
    }

    public function getParam(string $name)
    {
        return $this->body[$name];
    }

    public function hasParam(string $name)
    {
        return isset($this->body[$name]);
    }

    public function paramIsEmpty(string $name)
    {
        return empty($this->body[$name]);
    }

    public function getParams()
    {
        return $this->body;
    }

    public function hasQuery(string $name)
    {
        return isset($this->query[$name]);
    }

    public function getQuery(string $name)
    {
        return $this->query[$name];
    }

    public function getQuerys()
    {
        return $this->query;
    }

    public function getPathInfo()
    {
        return strtok($this->server['REQUEST_URI'], '?');
    }

    public function getUri()
    {
        return $this->server['REQUEST_URI'];
    }

    public function hasMethod()
    {
        return isset($this->server['REQUEST_METHOD']);
    }

    public function getMethod()
    {
        return $this->server['REQUEST_METHOD'];
    }

    public function getHost()
    {
        return $this->server['HTTP_HOST'];
    }

    public function hasReferer()
    {
        return !empty($this->server['HTTP_REFERER']);
    }

    public function getReferer()
    {
        return $this->server['HTTP_REFERER'];
    }

    public function getScript()
    {
        return $this->server['SCRIPT_NAME'];
    }

    public function setStatusCode(int $code)
    {
        http_response_code($code);
    }

    public function session(?string $name = null, $value = null)
    {
        if(!is_null($name) && !is_null($value))
        {
            app()->get(Session::class)->put($name, $value);
            return;
        }

        if(!is_null($name))
        {
            return app()->get(Session::class)->get($name);
        }

        return app()->get(Session::class);
    }

    public function cookie(?string $name = null, $value = null, int $expires = 0)
    {
        if (!is_null($name) && !is_null($value) && $expires != 0) {
            app()->get(Cookie::class)->put($name, $value, $expires);
            return;
        }

        if (!is_null($name)) {
            return app()->get(Cookie::class)->get($name);
        }

        return app()->get(Cookie::class);
    }

    public function hasFile(string $name)
    {
        return isset($this->files[$name]['tmp_name']);
    }

    public function getFile(string $name)
    {
        return $this->files[$name]['tmp_name'];
    }

    public function getFileName(string $name)
    {
        return $this->files[$name]['name'];
    }

    public function getFileType(string $name)
    {
        return $this->files[$name]['type'];
    }

    public function getFileError(string $name)
    {
        return $this->files[$name]['error'];
    }

    public function getFileSize(string $name)
    {
        return $this->files[$name]['size'];
    }

    public function fileIsEmpty(string $name)
    {
        return empty($this->files[$name]['tmp_name']);
    }

    public function getFileExtension(string $name)
    {
        return pathinfo($this->getFileName($name), PATHINFO_EXTENSION);
    }

    public function fileIsArray(string $name)
    {
        return is_array($this->files[$name]['tmp_name']);
    }

    public function getFiles()
    {
        return $this->files;
    }

    public function getBaseUrl()
    {
        $scheme = str_contains($_SERVER['SERVER_PROTOCOL'],'https') ? 'https://' : 'http://';

        $base = $scheme.$this->getHost();

        return $base;
    }
}
