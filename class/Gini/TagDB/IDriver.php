<?php

namespace Gini\TagDB;

interface IDriver
{
    public function get($key);
    public function set($key, $data);
}
