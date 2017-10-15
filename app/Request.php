<?php


namespace App;


class Request {

    protected $fields = [];

    public function __construct()
    {
        if(!isset($_GET)){
            return;
        }

        array_walk($_GET, function($value, $key){
            $this->fields[$key] = $value;
        }, array_keys($_GET));
    }
    /**
     * get all fields
     *
     * @return array
     */
    public function all()
    {
        return $this->fields;
    }

    /**
     * get one value
     *
     * @param $key
     * @return mixed
     */
    public function only($key)
    {
        return $this->fields[$key];
    }
}