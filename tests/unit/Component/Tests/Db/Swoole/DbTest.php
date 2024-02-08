<?php

namespace Imi\Test\Component\Tests\Db\Swoole;

use Imi\Test\Component\Tests\Db\DbBaseTest;

/**
 * @testdox Swoole MySQL
 */
class DbTest extends DbBaseTest
{
    /**
     * Connection Pool's Name.
     *
     * @var string
     */
    protected $poolName = 'swooleMysql';
}
