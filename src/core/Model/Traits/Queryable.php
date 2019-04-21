<?php


namespace Chibi\Model\Traits;


use Chibi\Model\Exceptions\ModelNotFoundException;
use Chibi\Model\Katana;
use ReflectionException;
use PDO;

trait Queryable
{

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
     * Find a Model or thrown an exception
     *
     * @param $id
     * @return mixed
     * @throws ModelNotFoundException
     * @throws ReflectionException
     */
    public static function findOrFail($id)
    {
        $model = static::find($id);

        if(is_null($model)){
            $class = get_class_name(static::class);
            throw new ModelNotFoundException("Record of the model {$class} not found");
        }

        return $model;
    }

    /**
     * Where Query
     *
     * @param array $mapping
     * @return Katana|null
     */
    public static function where(array $mapping)
    {
        parent::connect();

        $keys = array_keys($mapping);

        $conditions = [];

        array_walk($keys, function ($key) use (&$conditions){
           $conditions[] = "{$key} = :{$key}";
        });

        $table = static::guessTableName();

        $query = static::$connexion->prepare("SELECT * FROM {$table} WHERE ". implode(' AND ', $conditions));


        foreach ($mapping as $key => &$value){
            $query->bindParam(":$key", $value);
        }

        $query->execute();

        $results = $query->fetchAll(PDO::FETCH_ASSOC);

        if(count($results) == 0){
            return null;
        }

        return new static($results[0]);
    }

    public static function all()
    {
        parent::connect();

        $table = static::guessTableName();

        $query = static::$connexion->query("SELECT * FROM {$table}");

        $results = $query->fetchAll(PDO::FETCH_ASSOC);

        if(count($results) == 0){
            return null;
        }

        return array_map(function($record){
            return new self($record);
        }, $results);
    }
}