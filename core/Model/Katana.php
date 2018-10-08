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
        $resut = static::$connexion->prepare("SELECT * FROM {$table} WHERE id={$id}");
        $resut->execute();
        $results = $resut->fetchAll(PDO::FETCH_ASSOC);

        if(count($results) == 0){
            return null;
        }

        return new static(
            $results[0]
        );
    }
}