<?php

namespace Gini\ORM\TagDB;

class Tag  extends Object
{
    public $name = 'string:30';
    public $data = 'array';

    protected static $db_index = [
        'unique:name',
    ];

}
