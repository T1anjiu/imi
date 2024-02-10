<?php

return [
    'configs'    => [
    ],
    // bean scanning directory
    'beanScan'    => [
        'Imi\Test\HttpServer\HttpsTestServer\Controller',
        'Imi\Test\HttpServer\OutsideController',
    ],
    'beans'    => [
        'HttpDispatcher'    => [
            'middlewares'    => [
                \Imi\Test\HttpServer\Middleware\RequestLogMiddleware::class,
                \Imi\Server\Http\Middleware\RouteMiddleware::class,
            ],
        ],
    ],
];
