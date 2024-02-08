<?php

namespace Imi\Test\HttpServer\ApiServer\Controller;

use Imi\Controller\HttpController;
use Imi\Server\Route\Annotation\Action;
use Imi\Server\Route\Annotation\Controller;
use Imi\Util\MemoryTableManager;

/**
 * @Controller("/memoryTable/")
 */
class MemoryTableController extends HttpController
{
    /**
     * 设置行的数据.
     *
     * @Action
     *
     * @return array
     */
    public function setAndGet()
    {
        $key = '1';
        $row = [
            'name'  => 'imi',
        ];

        return [
            'setResult' => MemoryTableManager::set('t1', $key, $row),
            'getField'  => MemoryTableManager::get('t1', $key, 'name'),
            'getRow'    => MemoryTableManager::get('t1', $key),
        ];
    }

    /**
     * Delete row data.
     *
     * @Action
     *
     * @return array
     */
    public function del()
    {
        $key = '2';
        $row = [
            'name'  => 'yurun',
        ];

        return [
            'setResult' => MemoryTableManager::set('t1', $key, $row),
            'getRow1'   => MemoryTableManager::get('t1', $key),
            'delResult' => MemoryTableManager::del('t1', $key),
            'getRow2'   => MemoryTableManager::get('t1', $key),
        ];
    }

    /**
     * Does the row data exist.
     *
     * @Action
     *
     * @return array
     */
    public function exist()
    {
        $key = '2';
        $row = [
            'name'  => 'yurun',
        ];

        return [
            'existResult1'  => MemoryTableManager::exist('t1', $key),
            'setResult'     => MemoryTableManager::set('t1', $key, $row),
            'existResult2'  => MemoryTableManager::exist('t1', $key),
        ];
    }

    /**
     * atomic increment.
     *
     * @Action
     *
     * @return array
     */
    public function incr()
    {
        $key = '3';
        $row = [
            'name'      => 'yurun',
            'quantity'  => 0,
        ];

        return [
            'setResult'     => MemoryTableManager::set('t1', $key, $row),
            'incrResult'    => MemoryTableManager::incr('t1', $key, 'quantity', 1),
            'getQuantity'   => MemoryTableManager::get('t1', $key, 'quantity'),
        ];
    }

    /**
     * atomic decrement.
     *
     * @Action
     *
     * @return array
     */
    public function decr()
    {
        $key = '4';
        $row = [
            'name'      => 'yurun',
            'quantity'  => 0,
        ];

        return [
            'setResult'     => MemoryTableManager::set('t1', $key, $row),
            'decrResult'    => MemoryTableManager::decr('t1', $key, 'quantity', 1),
            'getQuantity'   => MemoryTableManager::get('t1', $key, 'quantity'),
        ];
    }

    /**
     * Get the number of table rows.
     *
     * @Action
     *
     * @return array
     */
    public function count()
    {
        return [
            'count'    => MemoryTableManager::count('t1'),
        ];
    }

    /**
     * Set row data.
     *
     * @Action
     *
     * @return array
     */
    public function lockCallableSetAndGet()
    {
        $result = null;
        MemoryTableManager::lock('t1', function () use (&$result) {
            $key = '1';
            $row = [
                'name'  => 'imi',
            ];
            $result = [
                'setResult' => MemoryTableManager::set('t1', $key, $row),
                'getField'  => MemoryTableManager::get('t1', $key, 'name'),
                'getRow'    => MemoryTableManager::get('t1', $key),
            ];
        });

        return $result;
    }

    /**
     * Set row data.
     *
     * @Action
     *
     * @return array
     */
    public function lockSetAndGet()
    {
        MemoryTableManager::lock('t1');
        $result = null;
        try
        {
            $key = '1';
            $row = [
                'name'  => 'imi',
            ];
            $result = [
                'setResult' => MemoryTableManager::set('t1', $key, $row),
                'getField'  => MemoryTableManager::get('t1', $key, 'name'),
                'getRow'    => MemoryTableManager::get('t1', $key),
            ];
        }
        finally
        {
            MemoryTableManager::unlock('t1');
        }

        return $result;
    }
}
