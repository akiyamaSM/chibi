<?php


namespace App;

use Kolores\Model\Katana;

class Friend extends Katana
{
    static $table = 'friends';

    static $id = 'friend_id';

    protected $data = 'is';

    public  function test()
    {
        if (isset($this->data)) {
            return $this->data;
        }
    }
}