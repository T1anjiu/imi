<?php

namespace Imi\Test\Component\Event\Listener;

use Imi\Bean\Annotation\Listener;
use Imi\Event\EventParam;
use Imi\Event\IEventListener;
use Imi\Test\Component\Tests\EventTest;
use PHPUnit\Framework\Assert;

/**
 * @Listener("IMITEST.EVENT.D")
 */
class EventDListener implements IEventListener
{
    /**
     * Event Handling Method
     *
     * @param \Imi\Event\EventParam $e
     *
     * @return void
     */
    public function handle(EventParam $e)
    {
        Assert::assertEquals('IMITEST.EVENT.D', $e->getEventName());
        Assert::assertEquals(EventTest::class, \get_class($e->getTarget()));
        $data = $e->getData();
        Assert::assertEquals('imi', $data['name']);
        $data['return'] = 19260817;
    }
}
