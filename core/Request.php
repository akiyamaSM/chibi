<?php


namespace Chibi;


class Request {

    protected $fields = [];

    public function __construct()
    {
        if(!isset($_REQUEST)){
            return;
        }

        array_walk($_REQUEST, function($value, $key){
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