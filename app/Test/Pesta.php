<?php

namespace App\Test;

use Chibi\Container;

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
