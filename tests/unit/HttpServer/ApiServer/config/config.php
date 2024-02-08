<?php

return [
    'configs'    => [
    ],
    // Bean Scanning Directories
    'beanScan'    => [
        'Imi\Test\HttpServer\ApiServer\Controller',
        'Imi\Test\HttpServer\Modules',
        'Imi\Test\HttpServer\OutsideController',
        'Imi\Test\HttpServer\ApiServer\Error',
    ],
    'beans'    => [
        'SessionManager'    => [
            'handlerClass'    => \Imi\Server\Session\Handler\File::class,
        ],
        'SessionFile'    => [
            'savePath'    => dirname(__DIR__, 2) . '/.session/',
        ],
        'SessionConfig'    => [
        ],
        'SessionCookie'    => [
            'lifetime'    => 86400 * 30,
        ],
        'HttpDispatcher'    => [
            'middlewares'    => [
                'OptionsMiddleware',
                'ExecuteTimeoutMiddleware',
                \Imi\Test\HttpServer\Middleware\RequestLogMiddleware::class,
                \Imi\Server\Session\Middleware\HttpSessionMiddleware::class,
                \Imi\Test\HttpServer\ApiServer\Middleware\PoweredBy::class,
                \Imi\Server\Http\Middleware\RouteMiddleware::class,
            ],
        ],
        'OptionsMiddleware' => [
            'allowOrigin'   => 'http://127.0.0.1',
            'optionsBreak'  => true,
        ],
        'HtmlView'    => [
            'templatePath'    => dirname(__DIR__) . '/template/',
            // Supported template file extensions, in order of priority
            'fileSuffixs'        => [
                'tpl',
                'html',
                'php',
            ],
        ],
        'ExecuteTimeoutMiddleware' => [
            'maxExecuteTime'    => 3000,
        ],
        'HttpNotFoundHandler'   => [
            'handler'   => 'MyHttpNotFoundHandler',
        ],
    ],
    'middleware'    => [
        'groups'    => [
            'test'  => [
                \Imi\Test\HttpServer\ApiServer\Middleware\Middleware4::class,
            ],
        ],
    ],
];
