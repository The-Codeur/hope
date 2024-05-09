<?php
namespace Meerkat\Router;

class RouteException extends \Exception
{
    public static function e404()
    {
        header('HTTP/1.1 404 Not Found');

        $error = <<<EOT
            <!DOCTYPE html>
            <html lang="fr">
            <head>
                <meta charset="UTF-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>page not found</title>
            
                <style>
                
                    body {
                        height: 100vh; 
                        display: flex;
                        justify-content: center;
                        align-items: center;
                        background: #ccc;
                    }
            
                    h4 {
                        position: relative;
                        padding: .5em 0 .5em .5em;
                        background: #f5f5f5;
                        border-radius: 8px;
                    }
            
                    h4 > a {
                        padding: .5em;
                        background: #455a64;
                        color: #f5f5f5;
                        border-top-right-radius: 8px;
                        border-bottom-right-radius: 8px;
                    }
            
            
                </style>
            </head>
            <body>
                <h4>Cette page n'existe pas ou plus, <a href="/">revenir à l'accueil</a></h4>
            </body>
            </html> 
        EOT;


        if (!empty(glob(BASE_PATH . 'src' . DS . 'views' . DS . 'e404.*')[0])) {
            require_once glob(BASE_PATH . 'src' . DS . 'views' . DS . 'e404.*')[0];
        } else {

            echo $error;
        }
        exit;
    }
}