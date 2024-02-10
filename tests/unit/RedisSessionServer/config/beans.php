<?php  
  
use Imi\Log\LogLevel;  
  
$rootPath = dirname(__DIR__) . '/';  
  
return [  
    'hotUpdate' => [  
        'status' => false, // Set to true to enable hot updates. Comment out to disable. Recommended to disable in production environments.  
  
        // --- File modification time monitoring ---  
        // 'monitorClass' => \Imi\HotUpdate\Monitor\FileMTime::class,  
        'timespan' => 1, // Detection interval in seconds.  
  
        // --- Inotify extension monitoring ---  
        // 'monitorClass' => \Imi\HotUpdate\Monitor\Inotify::class,  
        // 'timespan' => 1, // Detection interval in seconds. For better performance with the extension, it is recommended to set this to 0.  
  
        // 'includePaths' => [], // Array of paths to include.  
        'excludePaths' => [  
            $rootPath . '.git',  
            $rootPath . 'bin',  
            $rootPath . 'logs',  
        ], // Array of paths to exclude. Supports wildcards (*).  
    ],  
    'Logger' => [  
        'exHandlers' => [  
            // Info level logs do not output traces.  
            [  
                'class' => \Imi\Log\Handler\File::class,  
                'options' => [  
                    'levels' => [LogLevel::INFO],  
                    'fileName' => dirname(__DIR__) . '/logs/{Y}-{m}-{d}.log',  
                    'format' => '{Y}-{m}-{d} {H}:{i}:{s} [{level}] {message}',  
                ],  
            ],  
            // Specified level logs output traces.  
            [  
                'class' => \Imi\Log\Handler\File::class,  
                'options' => [  
                    'levels' => [  
                        LogLevel::ALERT,  
                        LogLevel::CRITICAL,  
                        LogLevel::DEBUG,  
                        LogLevel::EMERGENCY,  
                        LogLevel::ERROR,  
                        LogLevel::NOTICE,  
                        LogLevel::WARNING,  
                    ],  
                    'fileName' => dirname(__DIR__) . '/logs/{Y}-{m}-{d}.log',  
                    'format' => "{Y}-{m}-{d} {H}:{i}:{s} [{level}] {message}\n{trace}",  
                    'traceFormat' => '#{index}  {call} called at [{file}:{line}]',  
                ],  
            ],  
        ],  
    ],  
];