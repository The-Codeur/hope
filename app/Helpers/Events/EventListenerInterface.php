<?php
namespace App\Helpers\Events;

interface EventListenerInterface 
{
    public function getEvents():array;
}