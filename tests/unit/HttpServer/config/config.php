<?php

return [
    // project root namespace
    'namespace'    => 'Imi\Test\HttpServer',

    // Configuration
    'configs'    => [
        'beans'        => __DIR__ . '/beans.php',
    ],

    // Scan directory
    'beanScan'    => [
        'Imi\Test\HttpServer\Listener',
        'Imi\Test\HttpServer\Task',
        'Imi\Test\HttpServer\Process',
        'Imi\Test\HttpServer\Cron',
        'Imi\Test\HttpServer\Listener',
    ],

    // Component namespace
    'components'    => [
    ],

    // Main server configuration
    'mainServer'    => [
        'namespace'    => 'Imi\Test\HttpServer\ApiServer',
        'type'         => Imi\Server\Type::HTTP,
        'host'         => imiGetEnv('SERVER_HOST', '127.0.0.1'),
        'port'         => 13000,
        'mode'         => \SWOOLE_BASE,
        'configs'      => [
            'worker_num'        => 2,
            'task_worker_num'   => 1,
        ],
    ],

    // Subserver (port listening) configuration
    'subServers'    => [
        'SessionTest'   => [
            'namespace' => 'Imi\Test\HttpServer\SessionTestServer',
            'type'      => Imi\Server\Type::HTTP,
            'host'      => imiGetEnv('SERVER_HOST', '127.0.0.1'),
            'port'      => 13005,
        ],
        'HttpsTest'     => [
            'namespace' => 'Imi\Test\HttpServer\HttpsTestServer',
            'type'      => Imi\Server\Type::HTTP,
            'host'      => imiGetEnv('SERVER_HOST', '127.0.0.1'),
            'port'      => 13006,
            'sockType'  => \SWOOLE_SOCK_TCP | \SWOOLE_SSL,
            'configs'   => [
                'ssl_cert_file'     => dirname(__DIR__, 3) . '/ssl/server.crt',
                'ssl_key_file'      => dirname(__DIR__, 3) . '/ssl/server.key',
            ],
        ],
        'Http2Test'   => [
            'namespace' => 'Imi\Test\HttpServer\Http2TestServer',
            'type'      => Imi\Server\Type::HTTP,
            'host'      => imiGetEnv('SERVER_HOST', '127.0.0.1'),
            'port'      => 13007,
            'sockType'  => \SWOOLE_SOCK_TCP | \SWOOLE_SSL,
            'configs'   => [
                'open_http2_protocol'   => true,
                'ssl_cert_file'         => dirname(__DIR__, 3) . '/ssl/server.crt',
                'ssl_key_file'          => dirname(__DIR__, 3) . '/ssl/server.key',
            ],
        ],
    ],

    // Connection pool configuration
    'pools'    => [
        // main database
        'maindb'    => [
            // Sync pool
            'sync'    => [
                'pool'    => [
                    'class'        => \Imi\Db\Pool\SyncDbPool::class,
                    'config'       => [
                        'maxResources'    => 10,
                        'minResources'    => 0,
                    ],
                ],
                'resource'    => [
                    'host'        => imiGetEnv('MYSQL_SERVER_HOST', '127.0.0.1'),
                    'port'        => imiGetEnv('MYSQL_SERVER_PORT', 3306),
                    'username'    => imiGetEnv('MYSQL_SERVER_USERNAME', 'root'),
                    'password'    => imiGetEnv('MYSQL_SERVER_PASSWORD', 'root'),
                    'database'    => 'mysql',
                    'charset'     => 'utf8mb4',
                ],
            ],
            // Asynchronous pool, used by worker processes
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
                    'database'    => 'mysql',
                    'charset'     => 'utf8mb4',
                ],
            ],
        ],
        'redis'    => [
            'sync'    => [
                'pool'    => [
                    'class'        => \Imi\Redis\SyncRedisPool::class,
                    'config'       => [
                        'maxResources'    => 10,
                        'minResources'    => 0,
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
    ],

    // Database configuration
    'db'    => [
        // Number of default connection pool names
        'defaultPool'    => 'maindb',
    ],

    // redis configuration
    'redis' => [
        // Number of default connection pool names
        'defaultPool'   =configuration> 'redis',
    ],

    // Memory table 
    'memoryTable'   => [
        't1'    => [
            'columns'   => [
                ['name' => 'name', 'type' => \Swoole\Table::TYPE_STRING, 'size' => 16],
                ['name' => 'quantity', 'type' => \Swoole\Table::TYPE_INT],
            ],
            'lockId'    => 'memoryTableLock',
        ],
        'connectContext'    => [
            'class'  => \Imi\Server\ConnectContext\StoreHandler\MemoryTable\ConnectContextOption::class,
            'lockId' => 'redisConnectContextLock',
        ],
    ],

    // Lock
    'lock'  => [
        'list'  => [
            // 'atomic' =>  [
            //     'class' =>  'AtomicLock',
            //     'options'   =>  [
            //         'atomicName'    =>  'atomicLock',
            //     ],
            // ],
            'memoryTableLock' => [
                'class'     => 'RedisLock',
                'options'   => [
                    'poolName'  => 'redis',
                ],
            ],
            'redisConnectContextLock' => [
                'class'     => 'RedisLock',
                'options'   => [
                    'poolName'  => 'redis',
                ],
            ],
        ],
    ],

    // atmoic configuration
    'atomics'    => [
        'atomicLock'   => 1,
    ],
];
