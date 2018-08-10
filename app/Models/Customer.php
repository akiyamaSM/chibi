<?php

namespace App\Models;

use Javanile\Moldable\Storable;

class Customer extends Storable
{

    public $id = self::PRIMARY_KEY;
    public $name = '';

}
