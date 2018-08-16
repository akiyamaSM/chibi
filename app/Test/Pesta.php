<?php

namespace App\Test;

use Kolores\Container;

class Pesta
{

    /**
     * Constructor
     */
    public function __construct(Container $file, array $f)
    {
         print_r($f);
         echo get_class($file);
    }
}
