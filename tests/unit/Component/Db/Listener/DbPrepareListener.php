<?php

namespace Imi\Test\Component\Db\Listener;

use Imi\App;
use Imi\Bean\Annotation\Listener;
use Imi\Db\Event\Param\DbPrepareEventParam;
use Imi\Event\EventParam;
use Imi\Event\IEventListener;
use Imi\Log\Log;

/**
 * @Listener("IMI.DB.PREPARE")
 */
class DbPrepareListener implements IEventListener
{
    /**
     * Event Handling Method
     *
     * @param DbPrepareEventParam $e
     *
     * @return void
     */
    public function handle(EventParam $e)
    {
        if (false !== App::get('DB_LOG'))
        {
            Log::info(sprintf('[prepare] %s', $e->sql));
        }
    }
}
