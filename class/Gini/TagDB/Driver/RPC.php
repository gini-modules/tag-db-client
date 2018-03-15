<?php

namespace Gini\TagDB\Driver;

class RPC implements \Gini\TagDB\IDriver
{
    public static $cacheTimeout = 86400;
    private $_rpc;
    private $_opt;
    public function __construct(array $opt)
    {
        $this->_opt = $opt;
    }

    private static function getCacheTimeout()
    {
        $timeout = \Gini\Config::get('tag-db-client.cache-timeout');
        $timeout = is_numeric($timeout) ? $timeout : self::$cacheTimeout;
        $float = (int) ($timeout / 10);
        $minFloat = 10;
        $float = ($float>$minFloat) ? $float : $minFloat;
        $timeout += rand(1, $float);
        return $timeout;
    }

    private function getRPC()
    {
        $opt = $this->_opt;
        $url = $opt['url'];
        $client = $opt['client'];
        $clientID = $client['id'];
        $clientSecret = $client['secret'];
        $rpc = \Gini\IoC::construct('\Gini\RPC', $url);

        $cacheKey = "app#{$url}#{$clientID}#token#{$clientSecret}";
        $token = self::cache($key);
        if ($token) {
            $rpc->setHeader(['X-Gini-Session' => $token]);
        } else {
            $token = $rpc->tagdb->authorize($clientID, $clientSecret);
            if ($token) {
                self::cache($key, $token, 720);
            }
        }

        return $rpc;
    }

    public function get($key)
    {
        $ckey = md5(J($key));
        $cacheKey = "tag-db-client#{$ckey}";
        $data = self::cache($cacheKey);
        if (is_array($data)) {
            return $data;
        }
        $data = $this->getRPC()->tagdb->data->get($key);
        self::cache($cacheKey, $data);
        return $data;
    }

    public function set($key, $data)
    {
        $bool = $this->getRPC()->tagdb->data->set($key, $data);
        if ($bool) {
            $ckey = md5(J($key));
            $cacheKey = "tag-db-client#{$ckey}";
            self::cache($cacheKey, $data);
        }
        return $bool;
    }

    private static function cache($key, $value=null, $timeout=null)
    {
        $cacher = \Gini\Cache::of('chemdb');
        if (is_null($value)) {
            return $cacher->get($key);
        }
        $cacher->set($key, $value, $timeout ?: self::getCacheTimeout());
    }

}
