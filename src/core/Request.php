<?php

namespace Chibi;

class Request
{

    protected $fields = [];

    protected $method;

    public function __construct()
    {
        if (!isset($_REQUEST)) {
            return;
        }

        if($_SERVER['REQUEST_METHOD']){
            $this->method = $_SERVER['REQUEST_METHOD'];
        }

        array_walk($_REQUEST, function($value, $key) {
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


    /**
     * Return the array minus a specific keys
     * @param $keys
     * @return array
     */
    public function except($keys)
    {
        return $this->except_keys(
            func_get_args()
        );
    }

    /**
     * Perform the exception
     *
     * @param array $keys
     * @return array
     */
    protected function except_keys(array $keys)
    {
        return array_filter($this->fields, function ($value, $index) use ($keys) {
            return !in_array($index, $keys);
        }, ARRAY_FILTER_USE_BOTH);
    }
    /**
     * Get
     *
     * @param $key
     * @return mixed
     */
    public function __get($key)
    {
        if ($this->has($key)) {
            return $this->fields[$key];
        }
        return null;
    }

    /**
     * Check if a key exists
     *
     * @param $key
     * @return bool
     */
    public function has($key)
    {
        return isset($this->fields[$key]);
    }

    /**
     * Check if its post
     *
     * @return bool
     */
    public function isPost()
    {
        return strtoupper($this->method) === 'POST';
    }

    /**
     * Check if its post
     *
     * @return bool
     */
    public function isGET()
    {
        return strtoupper($this->method) === 'GET';
    }

    /**
     * Get Method type
     *
     * @return string
     */
    public function getMethod()
    {
        return strtoupper($this->method);
    }
}
