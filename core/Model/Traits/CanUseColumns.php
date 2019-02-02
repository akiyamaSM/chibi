<?php


namespace Chibi\Model\Traits;

use Exception;

trait CanUseColumns
{
    static $id = 'id';

    protected $fields = [];

    /**
     * Assign values from the construct
     *
     * @param array $fields
     */
    protected function assign($fields = [])
    {
        if(count($fields) == 0){
            return;
        }

        foreach ($fields as $key => $value){
            $this->__set($key, $value);
        }

        return;
    }

    /**
     * Get the name of the Id column
     *
     * @return string
     */
    protected static function getIdKey()
    {
        return static::$id;
    }

    /**
     * Get the value of the Id column
     *
     * @return bool|null
     */
    public function getIdValue()
    {
        return isset($this->fields[static::getIdKey()]) ? $this->fields[static::getIdKey()] : null;
    }

    /**
     * Set the fields
     *
     * @param $key
     * @param $value
     */
    public function __set($key, $value)
    {
        $this->fields[$key] = $value;
    }

    /**
     * Get the saved value
     *
     * @param $key
     * @return mixed
     * @throws Exception
     */
    public function __get($key)
    {
        if (!isset($this->fields[$key])){
            throw new Exception("Can not find a column with the name of {$key}");
        }

        return $this->fields[$key];
    }

}