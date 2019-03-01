<?php

namespace Gini\TagDB\Driver;

class Agent implements \Gini\TagDB\IDriver
{

    public function __construct(array $opt)
    {
    }

    public function get($key)
    {
        $tag = a('tagdb/agent', [
            'name'=> $key
        ]);
        if (!$tag->id) return [];
        return (array)$tag->data;
    }

    public function set($key, $data)
    {
        $tag = a('tagdb/agent', [
            'name'=> $key
        ]);
        if (!$tag->id) {
            $tag->name = $key;
        }
        $tag->data = $data;
        return $tag->save();
    }

}
