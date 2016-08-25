<?php

namespace Gini\Module;

class TagDBClient
{
    public static function setup()
    {
    }

    public static function diagnose()
    {
        $error = [];

        $opts = \Gini\Config::get('tagdb.clients');
        $opts = (array)@$opts['rpc'];
        if (empty($opts)) {
            $errorp[] = '请配置tagdb.clients.rpc';
        }

        if (empty($opts['url'])) {
            $errorp[] = '请配置tagdb.clients.rpc.url';
        }

        if (empty($opts['client'])) {
            $errorp[] = '请配置tagdb.clients.rpc.client';
        }

        if (!empty($error)) {
            return $error;
        }
    }
}
