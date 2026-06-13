<?php namespace Viocon;

/**
 * This class gives the ability to access non-static methods statically
 *
 * Class AliasFacade
 *
 * @package Viocon
 */
class AliasFacade {

    /**
     * @var Container
     */
    protected static $swiftcmInstance;

    /**
     * @param $method
     * @param $args
     *
     * @return mixed
     */
    public static function __callStatic($method, $args)
    {
        if(!static::$swiftcmInstance) {
            static::$swiftcmInstance = new Container();
        }

        return call_user_func_array(array(static::$swiftcmInstance, $method), $args);
    }

    /**
     * @param Container $instance
     */
    public static function setVioconInstance(Container $instance)
    {
        static::$swiftcmInstance = $instance;
    }

    /**
     * @return \Viocon\Container $instance
     */
    public static function getVioconInstance()
    {
        return static::$swiftcmInstance;
    }
}