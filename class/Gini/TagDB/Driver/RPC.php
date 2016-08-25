<?php

namespace Gini\TagDB\Driver;

class RPC implements \Gini\TagDB\IDriver
{

    private $_rpc;
    public function __construct(array $opt)
    {
        $url = $opt['url'];
        $client = $opt['client'];
        $clientID = $client['id'];
        $clientSecret = $client['secret'];
        $rpc = \Gini\IoC::construct('\Gini\RPC', $url);
        $rpc->tagdb->authorize($clientID, $clientSecret);

        $this->_rpc = $rpc;
    }

    public function get($key)
    {
        return $this->_rpc->tagdb->data->get($key);
    }

    public function set($key, $data)
    {
        return $this->_rpc->tagdb->data->set($key, $data);
    }

}
