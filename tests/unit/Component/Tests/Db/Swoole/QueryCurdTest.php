<?php

namespace Imi\Test\Component\Tests\Db\Swoole;

use Imi\Test\Component\Tests\Db\QueryCurdBaseTest;

/**
 * @testdox Swoole MySQL QueryCurd
 */
class QueryCurdTest extends QueryCurdBaseTest
{
    /**
     * Connection Pool's Name.
     *
     * @var string
     */
    protected $poolName = 'swooleMysql';

    /**
     * Testing SQL for whereEx.
     *
     * @var string
     */
    protected $expectedTestWhereExSql = 'select * from `tb_article` where (`id` = :p1 and (`id` in (:p2) ) )';

    /**
     * Testing SQL for JSON queries.
     *
     * @var string
     */
    protected $expectedTestJsonSelectSql = 'select * from `tb_test_json` where `json_data`->"$.uid" = :p1';
}
