<?php

namespace Chibi\ObjectManager;

class Factory implements FactoryInterface
{
    /**
     * Create instance with arguments
     *
     * @param string $className
     * @param array $args
     * @return \Closure
     */
    public function create($className, array $args = [])
    {
        try {
            $om = \Chibi\AppObjectManager::getInstance();
            $classConstructor = new \ReflectionMethod($className, '__construct');
            $params = $classConstructor->getParameters();
            if (count($params) > 0) {
                foreach ($params as $param) {
                    if (!$param->hasType()) {
                        if (!$param->canBePassedByValue()) {
                            $args[] = ($param->isOptional()) ? $param->getDefaultValue() : null;
                        } else {
                            if (!$param->isOptional()) {
                                $args[] = null;
                            }
                        }                        
                    } else {
                        if ($param->isArray()) {
                            $args[] = ($param->isOptional()) ? $param->getDefaultValue() : array();
                        } else {
                            if (!$param->getType()->allowsNull()) {
                                $args[] = $om->resolve($param->getType()->__toString());
                            }
                        }
                    }
                }
            }
        } catch (\Exception $e) {
        }
        if ($args === []) {
            return new $className();
        } elseif ($args !== null) {
            return new $className(...array_values($args));
        }
    }
}
