<?php

namespace Imi\Test\HttpServer\Task;

use Imi\Task\Annotation\Task;
use Imi\Task\Interfaces\ITaskHandler;
use Imi\Task\TaskParam;

/**
 * @Task("Test1")
 */
class TestTask implements ITaskHandler
{
    /**
     * Task handling method
     *
     * @param TaskParam      $param
     * @param \Swoole\Server $server
     * @param int            $taskID
     * @param int            $workerID
     *
     * @return mixed
     */
    public function handle(TaskParam $param, \Swoole\Server $server, int $taskID, int $workerID)
    {
        $data = $param->getData();

        return date('Y-m-d H:i:s', $data['time']);
    }

    /**
     * Triggered when the task completes
     *
     * @param \swoole_server $server
     * @param int            $taskID
     * @param mixed          $data
     *
     * @return void
     */
    public function finish(\Swoole\Server $server, int $taskID, $data)
    {
    }
}
