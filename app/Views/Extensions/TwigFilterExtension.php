<?php
namespace App\Views\Extensions;

use Twig\Extension\AbstractExtension;

class TwigFilterExtension extends AbstractExtension
{
    private $container;

    public function __construct()
    {
        $this->container = app();
    }
    
    public function getFilters()
    {
        return [

        ];
    }
}