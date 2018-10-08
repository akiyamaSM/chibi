<?php


namespace Kolores\Model;

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
     * find By ID
     *
     * @param $id
     * @return mixed
     */
    public static function find($id)
    {
        parent::connect();
        $table = static::guessTableName();

        $resut = static::$connexion->prepare("SELECT * FROM :table WHERE id=:id");

        $resut->bindParam(':table', $table , PDO::PARAM_STR);
        $resut->bindParam(':id', $id, PDO::PARAM_INT);
        $resut->execute();

        $results = $resut->fetchAll(PDO::FETCH_ASSOC);

        if(count($results) == 0){
            return null;
        }

        return new static(
            $results[0]
        );
    }

    public function save()
    {

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
}