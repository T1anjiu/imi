<?php

return [
    'configs'    => [
    ],
    // bean scanning directory
    'beanScan'    => [
        'Imi\Test\HttpServer\SessionTestServer\Controller',
    ],
    'beans'    => [
        'SessionManager'    => [
            'handlerClass'    => \Imi\Server\Session\Handler\File::class,
        ],
        'SessionFile'    => [
            'savePath'    => dirname(__DIR__, 2) . '/.runtime/.session2',
        ],
        'SessionConfig'    => [
        ],
        'SessionCookie'    => [
            'enable'    => false,
        ],
        'HttpDispatcher'    => [
            'middlewares'    => [
                \Imi\Test\HttpServer\Middleware\RequestLogMiddleware::class,
                \Imi\Server\Session\Middleware\HttpSessionMiddleware::class,
                \Imi\Server\Http\Middleware\RouteMiddleware::class,
            ],
        ],
        'HtmlView'    => [
            'templatePath'    => dirname(__DIR__) . '/template/',
            // Supported template file extensions, listed in order of priority
            'fileSuffixs'        => [
                'tpl',
                'html',
                'php',
            ],
        ],
        \Imi\Server\Session\Middleware\HttpSessionMiddleware::class => [
            'sessionIdHandler'  => function (Imi\Server\Http\Message\Request $request) {
                return $request->getHeaderLine('X-Session-ID');
            },
        ],
    ],
];
