<?php

if(!function_exists('isTurbo'))
{
    function isTurbo()
    {
        return str_contains(getallheaders()['Accept'], 'text/vnd.turbo-stream.html');
    }
}