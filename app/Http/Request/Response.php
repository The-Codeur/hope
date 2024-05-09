<?php

namespace App\Http\Request;

class Response
{
    public function __construct(private string $content = '', private int $statusCode = 200, private array $headers = [])
    {
  
    }

    public function setContent(string $content)
    {
        $this->content = $content;
    }

    public function addContent(string $content)
    {
        $this->content .= $content;
    }

    public function setHeader(string $name, string $value)
    {
        $this->headers[$name] = $value;
    }

    public function setStatusCode(int $code)
    {
        $this->statusCode = $code;
    }

    public function json($content, int $statusCode = 200, array $headers = [])
    {

        $headers = $headers ?: config('api.headers');

        $response = new self(json_encode($content), $statusCode, $headers);

        return $response->send();
    }

    public function send()
    {
    
        http_response_code($this->statusCode);

        foreach($this->headers as $name => $value)
        {
            header(sprintf("%s: %s", $name, $value));
        }

        return $this->content;
    }
}
