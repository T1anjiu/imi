<?php

use Imi\Log\LogLevel;

return [
    'configs'    => [
    ],
    // Bean Scanning Directories
    'beanScan'    => [
        'Imi\Test\Component\Tests',
        'Imi\Test\Component\Aop',
        'Imi\Test\Component\Inject',
        'Imi\Test\Component\Event',
        'Imi\Test\Component\Enum',
        'Imi\Test\Component\Redis',
        'Imi\Test\Component\Db',
        'Imi\Test\Component\Cache',
        'Imi\Test\Component\Lock',
        'Imi\Test\Component\Model',
        'Imi\Test\Component\Validate',
        'Imi\Test\Component\Inherit',
        'Imi\Test\Component\Util\Imi',
        'Imi\Test\Component\Facade',
        'Imi\Test\Component\Annotation',
        'Imi\Test\Component\Partial',
        'Imi\Test\Component\Tool',
        'Imi\Test\Component\RequestContextProxy',
    ],
    'ignoreNamespace'   => [
        'Imi\Test\Component\Annotation\A\*',
        'Imi\Test\Component\Annotation\B\TestB',
    ],
    'beans'    => [
        'TestPropertyClass' => [
            'b' => 'bbb',
        ],
        'Logger'            => [
            'exHandlers'    => [
                // Specify the log level to output trace messages
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
                [
                    'class'        => \Imi\Log\Handler\File::class,
                    'options'      => [
                        'levels'        => [
                            LogLevel::INFO,
                        ],
                        'fileName'      => dirname(__DIR__) . '/logs/{Y}-{m}-{d}.log',
                        'format'        => '{Y}-{m}-{d} {H}:{i}:{s} [{level}] {message}',
                    ],
                ],
                [
                    'class'     => \Imi\Log\Handler\Console::class,
                    'options'   => [
                        'levels'        => [
                            'Test',
                        ],
                        'format'         => '{message}',
                        'logCacheNumber' => 10240,
                    ],
                ],
            ],
        ],
        'ErrorLog'          => [
            // 'level' =>  ,
        ],
        'DbQueryLog' => [
            'enable' => true,
        ],
    ],
    'imi'   => 'very six',
    'yurun' => '',

// Connection pool configuration  
'pools' => [  
    // Main database  
    'maindb' => [  
        'pool' => [  
            // Synchronous pool class name  
            'syncClass' => \Imi\Db\Pool\SyncDbPool::class,  
            // Asynchronous (coroutine) pool class name  
            'asyncClass' => \Imi\Db\Pool\CoroutineDbPool::class,  
            // Connection pool configuration  
            'config' => [  
                'maxResources' => 10,  
                'minResources' => 1,  
                'checkStateWhenGetResource' => false,  
            ],  
        ],  
            // Resource configuration for the connection pool
            'resource'    => [
                'host'        => imiGetEnv('MYSQL_SERVER_HOST', '127.0.0.1'),
                'port'        => imiGetEnv('MYSQL_SERVER_PORT', 3306),
                'username'    => imiGetEnv('MYSQL_SERVER_USERNAME', 'root'),
                'password'    => imiGetEnv('MYSQL_SERVER_PASSWORD', 'root'),
                'database'    => 'db_imi_test',
                'charset'     => 'utf8mb4',
            ],
        ],
        // Slave database for the main database
        'maindb.slave'    => [
            // Synchronous pool configuration
            'sync'    => [
                'pool'    => [
                    'class'        => \Imi\Db\Pool\SyncDbPool::class,
                    'config'       => [
                        'maxResources'    => 10,
                        'minResources'    => 1,
                    ],
                ],
                'resource'    => [
                    'host'        => imiGetEnv('MYSQL_SERVER_HOST', '127.0.0.1'),
                    'port'        => imiGetEnv('MYSQL_SERVER_PORT', 3306),
                    'username'    => imiGetEnv('MYSQL_SERVER_USERNAME', 'root'),
                    'password'    => imiGetEnv('MYSQL_SERVER_PASSWORD', 'root'),
                    'database'    => 'db_imi_test',
                    'charset'     => 'utf8mb4',
                ],
            ],
            // Asynchronous task pool utilized by worker processes
            'async'    => [
                'pool'    => [
                    'class'        => \Imi\Db\Pool\CoroutineDbPool::class,
                    'config'       => [
                        'maxResources'    => 10,
                        'minResources'    => 1,
                    ],
                ],
                'resource'    => [
                    'host'        => imiGetEnv('MYSQL_SERVER_HOST', '127.0.0.1'),
                    'port'        => imiGetEnv('MYSQL_SERVER_PORT', 3306),
                    'username'    => imiGetEnv('MYSQL_SERVER_USERNAME', 'root'),
                    'password'    => imiGetEnv('MYSQL_SERVER_PASSWORD', 'root'),
                    'database'    => 'db_imi_test',
                    'charset'     => 'utf8mb4',
                ],
            ],
        ],
        // swoole mysql
        'swooleMysql'    => [
            'pool'    => [
                // CoroutinePool
                'asyncClass'    => \Imi\Db\Pool\CoroutineDbPool::class,
                // Connection Pool Configuration
                'config'        => [
                    'maxResources'              => 10,
                    'minResources'              => 1,
                    'checkStateWhenGetResource' => false,
                ],
            ],
            // Connection Pool Resource Allocation
            'resource'    => [
                'host'        => imiGetEnv('MYSQL_SERVER_HOST', '127.0.0.1'),
                'port'        => imiGetEnv('MYSQL_SERVER_PORT', 3306),
                'username'    => imiGetEnv('MYSQL_SERVER_USERNAME', 'root'),
                'password'    => imiGetEnv('MYSQL_SERVER_PASSWORD', 'root'),
                'database'    => 'db_imi_test',
                'charset'     => 'utf8mb4',
                'dbClass'     => \Imi\Db\Drivers\Swoole\Driver::class,
            ],
        ],
        // mysqli
        'mysqli'    => [
            'pool'    => [
                // CoroutinePool
                'asyncClass'    => \Imi\Db\Pool\CoroutineDbPool::class,
                // Connection Pool Configuration
                'config'        => [
                    'maxResources'              => 10,
                    'minResources'              => 1,
                    'checkStateWhenGetResource' => false,
                ],
            ],
            // Connection Pool Resource Allocation
            'resource'    => [
                'host'        => imiGetEnv('MYSQL_SERVER_HOST', '127.0.0.1'),
                'port'        => imiGetEnv('MYSQL_SERVER_PORT', 3306),
                'username'    => imiGetEnv('MYSQL_SERVER_USERNAME', 'root'),
                'password'    => imiGetEnv('MYSQL_SERVER_PASSWORD', 'root'),
                'database'    => 'db_imi_test',
                'charset'     => 'utf8mb4',
                'dbClass'     => \Imi\Db\Drivers\Mysqli\Driver::class,
            ],
        ],
        'redis_test'    => [
            'sync'    => [
                'pool'    => [
                    'class'        => \Imi\Redis\SyncRedisPool::class,
                    'config'       => [
                        'maxResources'    => 10,
                        'minResources'    => 1,
                    ],
                ],
                'resource'    => [
                    'host'      => imiGetEnv('REDIS_SERVER_HOST', '127.0.0.1'),
                    'port'      => imiGetEnv('REDIS_SERVER_PORT', 6379),
                    'password'  => imiGetEnv('REDIS_SERVER_PASSWORD'),
                ],
            ],
            'async'    => [
                'pool'    => [
                    'class'        => \Imi\Redis\CoroutineRedisPool::class,
                    'config'       => [
                        'maxResources'    => 10,
                        'minResources'    => 1,
                    ],
                ],
                'resource'    => [
                    'host'      => imiGetEnv('REDIS_SERVER_HOST', '127.0.0.1'),
                    'port'      => imiGetEnv('REDIS_SERVER_PORT', 6379),
                    'password'  => imiGetEnv('REDIS_SERVER_PASSWORD'),
                ],
            ],
        ],
        'redis_cache'    => [
            'sync'    => [
                'pool'    => [
                    'class'        => \Imi\Redis\SyncRedisPool::class,
                    'config'       => [
                        'maxResources'    => 10,
                        'minResources'    => 1,
                    ],
                ],
                'resource'    => [
                    'host'        => imiGetEnv('REDIS_SERVER_HOST', '127.0.0.1'),
                    'port'        => imiGetEnv('REDIS_SERVER_PORT', 6379),
                    'password'    => imiGetEnv('REDIS_SERVER_PASSWORD'),
                    'serialize'   => false,
                    'db'          => imiGetEnv('REDIS_CACHE_DB', 1),
                ],
            ],
            'async'    => [
                'pool'    => [
                    'class'        => \Imi\Redis\CoroutineRedisPool::class,
                    'config'       => [
                        'maxResources'    => 10,
                        'minResources'    => 1,
                    ],
                ],
                'resource'    => [
                    'host'        => imiGetEnv('REDIS_SERVER_HOST', '127.0.0.1'),
                    'port'        => imiGetEnv('REDIS_SERVER_PORT', 6379),
                    'password'    => imiGetEnv('REDIS_SERVER_PASSWORD'),
                    'serialize'   => false,
                    'db'          => 1,
                ],
            ],
        ],
        'redis_manager_test'    => [
            'sync'    => [
                'pool'    => [
                    'class'        => \Imi\Redis\SyncRedisPool::class,
                    'config'       => [
                        'maxResources'    => 10,
                        'minResources'    => 1,
                    ],
                ],
                'resource'    => [
                    'host'        => imiGetEnv('REDIS_SERVER_HOST', '127.0.0.1'),
                    'port'        => imiGetEnv('REDIS_SERVER_PORT', 6379),
                    'password'    => imiGetEnv('REDIS_SERVER_PASSWORD'),
                    'serialize'   => false,
                    'db'          => imiGetEnv('REDIS_CACHE_DB', 1),
                ],
            ],
            'async'    => [
                'pool'    => [
                    'class'        => \Imi\Redis\CoroutineRedisPool::class,
                    'config'       => [
                        'maxResources'    => 10,
                        'minResources'    => 1,
                    ],
                ],
                'resource'    => [
                    'host'        => imiGetEnv('REDIS_SERVER_HOST', '127.0.0.1'),
                    'port'        => imiGetEnv('REDIS_SERVER_PORT', 6379),
                    'password'    => imiGetEnv('REDIS_SERVER_PASSWORD'),
                    'serialize'   => false,
                    'db'          => 1,
                ],
            ],
        ],
    ],
				// Database configuration  
				'db' => [  
			    // Default connection pool name  
			    'defaultPool'   => 'maindb',  
			],  
				// Redis configuration  
				'redis' => [  
			    // Default connection pool name  
			    'defaultPool'   => 'redis_test',  
			],  
				// Cache configuration  
				'cache' => [  
				// Default cache driver  
			   'default'   => 'file1',  
			],
	// Cache
    'caches'    => [
        'file1'  => [
            'handlerClass'  => \Imi\Cache\Handler\File::class,
            'option'        => [
                'savePath'              => dirname(__DIR__) . '/.runtime/cache/',
                'formatHandlerClass'    => \Imi\Util\Format\Json::class,
            ],
        ],
        'file2'  => [
            'handlerClass'  => \Imi\Cache\Handler\File::class,
            'option'        => [
                'savePath'    => dirname(__DIR__) . '/.runtime/cache/',
                // Callback for handling saved file names, which can generally be omitted
                'saveFileNameCallback'    => function ($savePath, $key) {
                    return \Imi\Util\File::path($savePath, sha1($key));
                },
                'formatHandlerClass'    => \Imi\Util\Format\Json::class,
            ],
        ],
        'redis' => [
            'handlerClass'  => \Imi\Cache\Handler\Redis::class,
            'option'        => [
                'poolName'              => 'redis_cache',
                'formatHandlerClass'    => \Imi\Util\Format\Json::class,
            ],
        ],
        'redisHash' => [
            'handlerClass'  => \Imi\Cache\Handler\RedisHash::class,
            'option'        => [
                'poolName'              => 'redis_cache',
                'separator'             => '->',
                'formatHandlerClass'    => \Imi\Util\Format\Json::class,
            ],
        ],
    ],
    // atmoic configuration
    'atomics'    => [
        'atomicLock'   => 1,
        'test',
    ],
    // lock
    'lock'  => [
        'list'  => [
            'redis' => [
                'class'     => 'RedisLock',
                'options'   => [
                    'poolName'  => 'redis_test',
                ],
            ],
            'atomic' => [
                'class'     => 'AtomicLock',
                'options'   => [
                    'atomicName'    => 'atomicLock',
                ],
            ],
        ],
    ],
    'yurun2'   => imiGetEnv('yurun'),
    'tools'    => [
        'generate/model'    => [
            'namespace' => [
                'Imi\Test\Component\Model' => [
                    'tables'    => [
                        'tb_tree',
                    ],
                    'withRecords'   => [
                        'tb_tree',
                    ],
                ],
            ],
        ],
    ],
];
