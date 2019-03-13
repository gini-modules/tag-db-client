<?php

namespace Gini\Controller\CLI\TagDBClient;

class GetNodeData extends \Gini\Controller\CLI
{
    public function __index($args)
    {
        $options = \Gini\Config::get('tagdb.clients');
        if (!isset($options['rpc']['options'])) return;
        $url = $options['rpc']['options']['url'];
        $clientID = $options['rpc']['options']['client']['id'];
        $clientSecret = $options['rpc']['options']['client']['secret'];
        $rpc = \Gini\IoC::construct('\Gini\RPC', $url);
        $rpc->connectTimeout(20000);
        $sqls = $rpc->tagdb->getNodeData($clientID, $clientSecret, \Gini\Config::get('app.node'));
        if (!$sqls) return;
        $sqls = explode("\n", $sqls);
        $db = a('tagdb/agent')->db();
        foreach ($sqls as $sql) {
            if (!$sql) continue;
            echo $sql . "\n";
            $db->query($sql);
        }
    }
}

