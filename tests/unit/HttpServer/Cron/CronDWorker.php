<?php

namespace Imi\Test\HttpServer\Cron;

use Imi\Cron\Contract\ICronTask;

class CronDWorker implements ICronTask
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
        var_dump('dynamic');
    }
}
