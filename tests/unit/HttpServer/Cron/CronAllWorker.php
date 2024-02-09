<?php

namespace Imi\Test\HttpServer\Cron;

use Imi\Cron\Annotation\Cron;
use Imi\Cron\Contract\ICronTask;

/**
 * @Cron(id="CronAllWorker", second="3n", type="all_worker")
 */
class CronAllWorker implements ICronTask
{
    /**
     * perform tasks
     *
     * @param string $id
     * @param mixed  $data
     *
     * @return void
     */
    public function run(string $id, $data)
    {
        var_dump('all');
    }
}
