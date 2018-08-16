<?php

namespace Kolores;

use Kolores\ObjectManager\Factory;
use Whoops\Run;

class AppObjectManager extends ObjectManager\ObjectManager
{
    /**
     * @var ObjectManager
     */
    protected static $instance;

    /**
     * Retrieve object manager
     *
     * @return AppObjectManager
     */
    public static function getInstance()
    {
        if (!self::$instance instanceof AppObjectManager) {
            $factory =  new ObjectManager\Factory();
            self::setInstance(new AppObjectManager($factory));           
        }
        return self::$instance;
    }

    /**
     * Set object manager instance
     *
     * @param AppObjectManager $appObjectManager
     * @return void
     */
    public static function setInstance(AppObjectManager $appObjectManager)
    {
        self::$instance = $appObjectManager;
    }

    /**
     * Constructor
     *
     * @param Factory $factory
     */
    public function __construct(Factory $factory) {
        parent::__construct($factory);
        self::$instance = $this;
    }
}
