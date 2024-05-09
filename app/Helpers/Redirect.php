<?php
namespace App\Helpers;

use App\Http\Request\Request;

class Redirect 
{
    public function __construct(private Request $request)
    {
        
    }


    public function to(string $location, int $statusCode = 200)
    {

        $this->request->setStatusCode($statusCode);

        header('Location: '.$location);

        exit;
    }

    public function back()
    {
        if($this->request->hasReferer())
        {
            header('Location: '.$this->request->getReferer());
        }else{
            header('Location: '. DS);
        }
        exit;
    }

    public function route(string $path, array $params = [])
    {
        header('Location: '.route($path, $params));

        exit;
    }
}