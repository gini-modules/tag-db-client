<?php
/**
* @file Agent.php
* @brief 本地存货云端的数据
* @author PiHiZi <pihizi@msn.com>
* @version 0.1.0
* @date 2019-03-01
 */

namespace Gini\ORM\TagDB;

class Agent extends \Gini\ORM\Base
{
    protected static $db_name = 'admin';

    public $name = 'string:30';
    public $data = 'array';

    protected static $db_index = [
        'unique:name',
    ];

}
