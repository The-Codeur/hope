<?php
namespace App\Helpers\Events;

use App\Exceptions\EventDuplicateException;

class Event
{
    protected array $listeners = [];

    public function on(string $event, callable $callback, int $priority = 0)
    {
        if(!$this->hasListener($event))
        {
            $this->listeners[$event] = [];
        }
        $this->checkDuplicateEvent($event, $callback);
        $listener = new Listener($callback, $priority);
        $this->listeners[$event][] = $listener;
        $this->sortListener($event);
        return $listener;
    }

    public function once(string $event, callable $callback, int $priority = 0)
    {
        return $this->on($event, $callback, $priority)->once();
    }

    public function emit(string $event, ...$params)
    {
        if($this->hasListener($event))
        {
            foreach($this->listeners[$event] as $listener)
            {
                $listener->handle($params);
                if($listener->stopPropation)
                {
                    break;
                }
            }
        }
    }

    public function subscriber(EventListenerInterface $subscribers)
    {
        $events = $subscribers->getEvents();
        
        foreach($events as $event => $method)
        {
            $this->on($event, [$subscribers, $method]);
        }
    }

    private function hasListener(string $event)
    {
        return array_key_exists($event, $this->listeners);
    }

    private function sortListener(string $event)
    {
        
        usort($this->listeners[$event], fn($a, $b) => $b->priority <=> $a->priority);
    }

    private function checkDuplicateEvent(string $event, callable $callback)
    {
        array_map(function($called) use ($callback){
            
            if($called->callback === $callback)
            {
                throw new EventDuplicateException("Event duplication is not allowed");
            }
        }, $this->listeners[$event]);
    }
}