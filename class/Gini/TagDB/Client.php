<?php

namespace Gini\TagDB;

class Client
{
    private $_driver;
    private static $_drivers = [];

    public static function of($name)
    {
        if (\Gini\Config::get('tagdb.tag-db-client-use-agent') && strtolower($name)=='rpc') {
            $name = 'agent';
        }
        if (!isset(self::$_drivers[$name])) {
            $opts = \Gini\Config::get('tagdb.clients');
            $opts = isset($opts[$name]) ? $opts[$name] : $opts['default'];
            self::$_drivers[$name] = \Gini\IoC::construct('\Gini\TagDB\Client', $opts['driver'], (array)@$opts['options']);
        }
        return self::$_drivers[$name];
    }

    public function __construct($driverName, array $options=[])
    {
        $driverClass = '\Gini\TagDB\Driver\\' . $driverName;
        $this->_driver = \Gini\IoC::construct($driverClass, $options);
        if (!$this->_driver instanceof \Gini\TagDB\IDriver) {
            throw new \Gini\TagDB\Driver\Exception();
        }
    }

    public function __call($method, $params)
    {
        return call_user_func_array([$this->_driver, $method], $params);
    }

}
