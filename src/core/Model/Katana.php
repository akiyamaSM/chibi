<?php


namespace Chibi\Model;

use Chibi\Model\Traits\CanUseColumns;
use Chibi\Model\Traits\Queryable;
use ReflectionClass;

class Katana extends Connexion
{
    use CanUseColumns, Queryable;

    static $table = null;

    /**
     * The constructor of the model.
     *
     * @param array $fields
     */
    public function __construct($fields = [])
    {
        static::$table = static::getTableName();

        $this->assign($fields);
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
     * @throws \ReflectionException
     */
    protected static function guessTableName()
    {
        $ref = new ReflectionClass(static::class);

        if(isset($ref->getDefaultProperties()['table'])){
            return $ref->getDefaultProperties()['table'];
        }
        return strtolower($ref->getShortName()). 's';
    }

    /**
     *  Save the current instance
     *
     * @throws \ReflectionException
     */
    public function save()
    {
        parent::connect();

        if(!$this->isAdd()){
            return $this->update();
        }

        $table = static::guessTableName();

        $fields = $this->fields;

        unset($fields[static::getIdKey()]);

        $keys = array_keys($fields);

        $sql = "INSERT INTO {$table} ";

        $sql.= $this->getSqlForInsert($fields);

        $query = static::$connexion->prepare($sql);

        array_walk($keys, function ($key, $value)  use ($query, $fields){
            $query->bindParam(":{$key}", $fields[$key]);
        });

        return $query->execute();
    }

    /**
     * Check if it should insert
     *
     * @return bool
     */
    protected function isAdd()
    {
        return is_null($this->getIdValue());
    }

    /**
     * Update the current instance
     *
     * @return mixed
     *
     * @throws \ReflectionException
     */
    public function update()
    {
        $table = static::guessTableName();

        $sql = "UPDATE {$table} SET ";

        $fields = $this->fields;

        unset($fields[static::getIdKey()]);

        $keys = array_keys($fields);

        $sql .= implode(',', array_map(function($key){
                return "{$key}=:{$key}";
            }, $keys)
        );

        $query = static::$connexion->prepare($sql ." WHERE {static::getIdKey()} = {$this->getIdValue()}");

        array_walk($keys, function ($key, $value)  use ($query, $fields){
            $query->bindParam(":{$key}", $fields[$key]);
        });

        return $query->execute();
    }

    /**
     * @return \BadMethodCallException|string
     */
    public function delete()
    {
        $idKey = self::getIdValue();

        if( is_null($idKey) ){
            return new \BadMethodCallException();
        }

        return static::destroy($idKey);
    }

    /**
     *  Destroy a set of items
     *
     * @param $id
     * @return string
     */
    public static function destroy($id)
    {
        $ids = is_array($id) ? $id : [$id];
        try{
            parent::connect();

            $table = static::guessTableName();
            $key = static::getIdKey();
            $ids = implode(",",  array_values($ids)) ;
            $resut = static::$connexion->prepare("DELETE FROM {$table} WHERE {$key} in ($ids)");

            return $resut->execute();
        }catch (\Exception $e){
            return $e->getMessage();
        }
    }

    /**
     * Create a new instance of a model
     *
     * @param array $fields
     * @return Katana
     */
    protected static function instantiate($fields = [])
    {
        return new static(
            $fields
        );
    }

    /**
     * Create a new instance and save it in the database
     *
     * @param array $fields
     * @return mixed
     * @throws \ReflectionException
     */
    public function create($fields = [])
    {
        $instance = static::instantiate($fields);

        return $instance->save();
    }

    /**
     * Get the sql part for insert
     *
     * @param $fields
     * @return string
     */
    protected function getSqlForInsert($fields)
    {
        $keys = array_keys($fields);
        $columns = array_map(function($key){
                return $key;
            }, $keys
        );

        $paramas = array_map(function($key){
                return ":{$key}";
            }, $keys
        );
        $sqlColumns = implode(',', $columns);

        $sqlparams = implode(',', $paramas);

        return "({$sqlColumns}) VALUES ({$sqlparams})";
    }
}