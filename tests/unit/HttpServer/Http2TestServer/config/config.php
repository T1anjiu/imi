<?php

return [
    'configs'    => [
    ],
    // bean scanning directory
    'beanScan'    => [
        'Imi\Test\HttpServer\Http2TestServer\Controller',
    ],
    'beans'    => [
        'HttpDispatcher'    => [
            'middlewares'    => [
                \Imi\Test\HttpServer\Middleware\RequestLogMiddleware::class,
                \Imi\Server\Http\Middleware\RouteMiddleware::class,
            ],
        ],
        'ConnectContextStore'   => [
            'handlerClass'  => \Imi\Server\ConnectContext\StoreHandler\Redis::class,
        ],
        'ConnectContextRedis'    => [
            'redisPool' => 'redis',
            'lockId'    => 'redisConnectContextLock',
        ],
        'ConnectContextMemoryTable' => [
            'tableName' => 'connectContext',
        ],
    ],
];
