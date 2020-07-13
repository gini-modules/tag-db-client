<?php

namespace Gini\ORM\TagDB;

class Tag  extends \Gini\ORM\Object
{
    protected static $db_name = 'admin';

    public $name = 'string:30';
    public $data = 'array';

    protected static $db_index = [
        'unique:name',
    ];

}
