<?php


namespace Kolores\Model;


use Exception;

class Katana
{
    static $table = null;

    protected $id = 'id';

    protected $fields = [];


    /**
     * The constructor of the model.
     */
    public function __construct()
    {
        static::$table = static::getTableName();
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

    /**
     * Get the table name of the model
     *
     * @return null
     */
    public static function getTableName()
    {
        return static::$table;
    }

    /**
     * Guess the table name
     *
     * @return null|string
     */
    public static function guessTableName()
    {
        if( !is_null(static::$table)){
            return static::$table;
        }

        return strtolower(get_class()). 's';
    }
}