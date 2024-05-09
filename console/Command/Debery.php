<?php
namespace Command;

class Debery
{
    public function __construct(
        private array $argv, 
        private int $argc)
    {
    }

    public function getArgv(int $key)
    {
        return $this->argv[$key];
    }

    public function getArgc()
    {
        return $this->argc;
    }

    public function argcOp()
    {
        return $this->argc;
    }

    public function notEmpty()
    {
        return !empty($this->argv);
    }

    public function getAll()
    {
        return $this->argv;
    }

    public function unset(int $key)
    {
        unset($this->argv[$key]);
    }
}