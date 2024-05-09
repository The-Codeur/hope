<?php

namespace App\Http\Controllers;

use App\Http\Request\Response;
use App\Http\Core\BaseController as Controller;

class DefaultController extends Controller
{
    public function index(Response $response)
    {
        return view($response, 'default');
    }

}
