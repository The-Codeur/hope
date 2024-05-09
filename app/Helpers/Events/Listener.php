<?php
namespace App\Helpers\Events;

class Listener
{
    public $callback;
    public $priority = 0;
    public $stopPropation = false;

    private bool $once = false;

    private int $calls = 0;

    public function __construct(callable $callback, int $priority)
    {
        $this->callback = $callback;
        $this->priority = $priority;
        
    }

    public function once()
    {
        $this->once = true;
        return $this;
    }

    public function stopPropation()
    {
        $this->stopPropation = true;
        return $this;
    }



    public function handle(array $params)
    {
        if($this->once && $this->calls > 0)
        {
            return null;
        }
        $this->calls++;

        return call_user_func_array($this->callback, $params);
    }
}