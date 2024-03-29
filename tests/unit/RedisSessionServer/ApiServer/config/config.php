<?php

return [
    'configs'    => [
    ],
    // bean scanning directory
    'beanScan'    => [
        'Imi\Test\RedisSessionServer\ApiServer\Controller',
    ],
    'beans'    => [
        'SessionManager'    => [
            'handlerClass'    => \Imi\Server\Session\Handler\Redis::class,
        ],
        'SessionRedis'    => [
            'poolName'              => 'redisSession',
            'formatHandlerClass'    => \Imi\Util\Format\Json::class,
            'keyPrefix'             => 'session:',
        ],
        'SessionConfig'    => [
        ],
        'SessionCookie'    => [
            'lifetime'    => 0,
        ],
        'HttpDispatcher'    => [
            'middlewares'    => [
                \Imi\Server\Session\Middleware\HttpSessionMiddleware::class,
                \Imi\Server\Http\Middleware\RouteMiddleware::class,
            ],
        ],
    ],
    'controller'    => [
        'singleton' => true,
    ],
];
