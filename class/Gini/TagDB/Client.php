<?php

namespace Gini\TagDB;

class Client
{
    private $_driver;
    private $_drivers = [];

    public function of($name)
    {
        if (!isset(self::$_drivers[$name])) {
            $opts = \Gini\Config::get('tagdb.client');
            $opts = isset($opts[$name]) ? $opts[$name] : $opts['default'];
            self::$_engines[$name] = \Gini\IoC::construct('\Gini\TagDB\Client', $opts['driver'], (array)@$opts['options']);
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
