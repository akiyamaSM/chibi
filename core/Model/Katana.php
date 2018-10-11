<?php


namespace Kolores\Model;

use Kolores\Model\Exceptions\ModelNotFoundException;
use Kolores\Model\Traits\CanUseColumns;
use PDO;

class Katana extends Connexion
{
    use CanUseColumns;

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
     */
    public static function guessTableName()
    {
        if( !is_null(static::$table)){
            return static::$table;
        }

        return strtolower(get_class()). 's';
    }

    /**
     * Find By ID
     *
     * @param $id
     * @return mixed
     */
    public static function find($id)
    {
        parent::connect();

        $table = static::guessTableName();

        $idKey = self::getIdKey();

        $query = static::$connexion->prepare("SELECT * FROM {$table} WHERE {$idKey}=:id");

        $query->bindParam(":id", $id, PDO::PARAM_INT);

        $query->execute();

        $results = $query->fetchAll(PDO::FETCH_ASSOC);

        if(count($results) == 0){
            return null;
        }

        return new static(
            $results[0]
        );
    }

    /**
     *  Save the current instance
     */
    public function save()
    {
        $table = static::guessTableName();

        if($this->isAdd()){
            var_dump("Should Add");
            return;
        }

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
     * Check if it should insert
     *
     * @return bool
     */
    protected function isAdd()
    {
        return is_null($this->getIdValue());
    }

    public function update()
    {

    }

    public function delete()
    {

    }

    /**
     *  Destroy a set of items
     * @param $id
     * @return string
     */
    public static function destroy($id)
    {
        $ids = is_array($id) ? $id : [$id];
        try{
            parent::connect();

            $table = static::guessTableName();
            $ids = implode(",",  array_values($ids)) ;
            $resut = static::$connexion->prepare("DELETE FROM {$table} WHERE id in ($ids)");

            return $resut->execute();
        }catch (\Exception $e){
            return $e->getMessage();
        }
    }

    /**
     * Create a new instance and save it in the database
     *
     * @param array $fields
     */
    public function create($fields = [])
    {
        $instance = static::instantiate($fields);

        return $instance->save();
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
     * Find a Model or thrown an exception
     *
     * @param $id
     * @return mixed
     * @throws ModelNotFoundException
     */
    public static function findOrFail($id)
    {
        $model = static::find($id);

        if(is_null($model)){
            $class = get_class();
            throw new ModelNotFoundException("Record of the model {$class} not found");
        }

        return $model;
    }
}