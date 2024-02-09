<?php

use Imi\Log\LogLevel;

$rootPath = dirname(__DIR__) . '/';

return [
'hotUpdate' => [
'status' => false, // Disable hot update by uncommenting this line, enable by default if not set, recommended to disable in production environment

// --- File modification time monitoring ---  
    // 'monitorClass' => \Imi\HotUpdate\Monitor\FileMTime::class,  
    'timespan' => 1, // Detection time interval, unit: second  
 
    // --- Inotify extension monitoring ---  
    // 'monitorClass' => \Imi\HotUpdate\Monitor\Inotify::class,  
    // 'timespan' => 1, // Detection time interval, unit: second, recommended to set to 0 for better performance when using the extension  
 
    // 'includePaths' => [], // An array of paths to include  
    'excludePaths' => [  
        $rootPath . '.git',  
        $rootPath . 'bin',  
        $rootPath . 'logs',  
      ], // An array of paths to exclude, supports wildcard *  
    ],
    'Logger'    => [
        'exHandlers'    => [
            // Info-level logs do not output trace information.
            [
                'class'        => \Imi\Log\Handler\File::class,
                'options'      => [
                    'levels'        => [LogLevel::INFO],
                    'fileName'      => dirname(__DIR__) . '/logs/{Y}-{m}-{d}.log',
                    'format'        => '{Y}-{m}-{d} {H}:{i}:{s} [{level}] {message}',
                ],
            ],
            // Specified-level logs output trace information.
            [
                'class'        => \Imi\Log\Handler\File::class,
                'options'      => [
                    'levels'        => [
                        LogLevel::ALERT,
                        LogLevel::CRITICAL,
                        LogLevel::DEBUG,
                        LogLevel::EMERGENCY,
                        LogLevel::ERROR,
                        LogLevel::NOTICE,
                        LogLevel::WARNING,
                    ],
                    'fileName'      => dirname(__DIR__) . '/logs/{Y}-{m}-{d}.log',
                    'format'        => "{Y}-{m}-{d} {H}:{i}:{s} [{level}] {message}\n{trace}",
                    'traceFormat'   => '#{index}  {call} called at [{file}:{line}]',
                ],
            ],
        ],
    ],
    // Enable superglobal variables
    'SuperGlobals'  => [
        'enable'    => true,
    ],
    'AutoRunProcessManager'   => [
        'processes' => [
            'CronProcess',
        ],
    ],
    'CronManager'   => [
        'tasks' => [
        ],
    ],
];
