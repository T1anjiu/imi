<?php

namespace Imi\Pool;

use Imi\Bean\BeanFactory;
use Imi\Pool\Interfaces\IPool;
use Imi\Pool\Interfaces\IPoolResource;
use Imi\Util\ArrayUtil;
use Imi\Worker;
use Swoole\Coroutine;

abstract class BasePool implements IPool
{
    /**
     * 池子名称.
     *
     * @var string
     */
    protected $name;

    /**
     * 池子存储.
     *
     * @var \Imi\Pool\PoolItem[]
     */
    protected $pool = [];

    /**
     * 配置.
     *
     * @var \Imi\Pool\Interfaces\IPoolConfig|array
     */
    protected $config;

    /**
     * 资源配置.
     *
     * @var mixed
     */
    protected $resourceConfig;

    /**
     * 垃圾回收定时器ID.
     *
     * @var int
     */
    protected $gcTimerId;

    /**
     * 心跳定时器ID.
     *
     * @var int
     */
    protected $heartbeatTimerId;

    /**
     * 当前配置序号.
     *
     * @var int
     */
    protected $configIndex = -1;

    /**
     * 正在添加中的资源数量.
     *
     * @var int
     */
    protected $addingResources = 0;

    /**
     * @param string                                $name
     * @param \Imi\Pool\Interfaces\IPoolConfig|null $config
     * @param array|null                            $resourceConfig
     */
    public function __construct(string $name, ?Interfaces\IPoolConfig $config = null, $resourceConfig = null)
    {
        $this->name = $name;
        if (null !== $config)
        {
            $this->config = $config;
        }
        if (!\is_array($resourceConfig) || ArrayUtil::isAssoc($resourceConfig))
        {
            $this->resourceConfig = [$resourceConfig];
        }
        else
        {
            $this->resourceConfig = $resourceConfig;
        }
    }

    /**
     * @return void
     */
    public function __init()
    {
        if (\is_array($this->config))
        {
            $this->config = BeanFactory::newInstance(PoolConfig::class, $this->config);
        }
    }

    /**
     * 获取池子名称.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * 获取池子配置.
     *
     * @return \Imi\Pool\Interfaces\IPoolConfig
     */
    public function getConfig(): Interfaces\IPoolConfig
    {
        return $this->config;
    }

    /**
     * 打开池子.
     *
     * @return void
     */
    public function open()
    {
        // 初始化队列
        $this->initQueue();
        // 填充最少资源数
        $this->fillMinResources();
        // 定时资源回收
        $this->stopAutoGC();
        $this->startAutoGC();
        // 心跳
        $this->stopHeartbeat();
        $this->startHeartbeat();
    }

    /**
     * 关闭池子，释放所有资源.
     *
     * @return void
     */
    public function close()
    {
        $this->stopAutoGC();
        $this->stopHeartbeat();
        if ($this->pool)
        {
            foreach ($this->pool as $item)
            {
                $item->getResource()->close();
            }
        }
        $this->pool = [];
        $this->initQueue();
    }

    /**
     * 释放资源占用.
     *
     * @param \Imi\Pool\Interfaces\IPoolResource $resource
     *
     * @return void
     */
    public function release(IPoolResource $resource)
    {
        $hash = $resource->hashCode();
        $pool = &$this->pool;
        if (isset($pool[$hash]))
        {
            $resource->reset();
            $pool[$hash]->release();
            $this->push($resource);
        }
    }

    /**
     * 资源回收.
     *
     * @return void
     */
    public function gc()
    {
        $pool = &$this->pool;
        if ($pool)
        {
            $hasGC = false;
            $config = $this->config;
            $maxActiveTime = $config->getMaxActiveTime();
            $maxUsedTime = $config->getMaxUsedTime();
            $time = microtime(true);
            foreach ($pool as $key => $item)
            {
                if (
                (null !== $maxActiveTime && $item->isFree() && $time - $item->getCreateTime() >= $maxActiveTime) // 最大存活时间
                || (null !== $maxUsedTime && $item->getLastReleaseTime() < $item->getLastUseTime() && $time - $item->getLastUseTime() >= $maxUsedTime) // 每次获取资源最长使用时间
                ) {
                    $item->getResource()->close();
                    unset($pool[$key]);
                    $hasGC = true;
                }
            }
            if ($hasGC)
            {
                $this->fillMinResources();
                $this->buildQueue();
            }
        }
    }

    /**
     * 填充最少资源数量.
     *
     * @return void
     */
    public function fillMinResources()
    {
        while ($this->config->getMinResources() - $this->getCount() > 0)
        {
            $this->addResource();
        }
    }

    /**
     * 添加资源.
     *
     * @return IPoolResource
     */
    protected function addResource()
    {
        $addingResources = &$this->addingResources;
        try
        {
            ++$addingResources;
            $resource = $this->createResource();
            $resource->open();

            $hash = $resource->hashCode();
            $this->pool[$hash] = new PoolItem($resource);

            $this->push($resource);

            return $resource;
        }
        finally
        {
            --$addingResources;
        }
    }

    /**
     * 初始化队列.
     *
     * @return void
     */
    abstract protected function initQueue();

    /**
     * 建立队列.
     *
     * @return void
     */
    abstract protected function buildQueue();

    /**
     * 创建资源.
     *
     * @return \Imi\Pool\Interfaces\IPoolResource
     */
    abstract protected function createResource(): IPoolResource;

    /**
     * 把资源加入队列.
     *
     * @param IPoolResource $resource
     *
     * @return void
     */
    abstract protected function push(IPoolResource $resource);

    /**
     * 开始自动垃圾回收.
     *
     * @return void
     */
    public function startAutoGC()
    {
        if (null !== Worker::getWorkerID() || Coroutine::stats()['coroutine_num'] > 0)
        {
            $gcInterval = $this->config->getGCInterval();
            if (null !== $gcInterval)
            {
                $this->gcTimerId = \Swoole\Timer::tick($gcInterval * 1000, [$this, 'gc']);
            }
        }
    }

    /**
     * 停止自动垃圾回收.
     *
     * @return void
     */
    public function stopAutoGC()
    {
        if (null !== $this->gcTimerId)
        {
            \Swoole\Timer::clear($this->gcTimerId);
        }
    }

    /**
     * 获得资源配置.
     *
     * @return mixed
     */
    public function getResourceConfig()
    {
        return $this->resourceConfig;
    }

    /**
     * 获取当前池子中资源总数.
     *
     * @return int
     */
    public function getCount()
    {
        return \count($this->pool) + $this->addingResources;
    }

    /**
     * 获取当前池子中正在使用的资源总数.
     *
     * @return int
     */
    public function getUsed()
    {
        return $this->getCount() - $this->getFree();
    }

    /**
     * 获取下一个资源配置.
     *
     * @return mixed
     */
    protected function getNextResourceConfig()
    {
        $resourceConfig = &$this->resourceConfig;
        if (!isset($resourceConfig[1]))
        {
            return $resourceConfig[0];
        }
        switch ($this->config->getResourceConfigMode())
        {
            case ResourceConfigMode::RANDOM:
                $index = mt_rand(0, \count($resourceConfig) - 1);
                break;
            default:
                $maxIndex = \count($resourceConfig) - 1;
                $configIndex = &$this->configIndex;
                if (++$configIndex > $maxIndex)
                {
                    $configIndex = 0;
                }
                $index = $configIndex;
                break;
        }

        return $resourceConfig[$index];
    }

    /**
     * 心跳.
     *
     * @return void
     */
    public function heartbeat()
    {
        $hasGC = false;
        $pool = &$this->pool;
        if ($pool)
        {
            foreach ($pool as $key => $item)
            {
                if ($item->isFree() && $item->lock())
                {
                    try
                    {
                        $resource = $item->getResource();
                        if (!$resource->checkState())
                        {
                            $resource->close();
                            unset($pool[$key]);
                            $hasGC = true;
                            $item = null;
                        }
                    }
                    finally
                    {
                        if ($item)
                        {
                            $item->release();
                        }
                    }
                }
            }
        }
        if ($hasGC)
        {
            $this->fillMinResources();
            $this->buildQueue();
        }
    }

    /**
     * 开始心跳维持资源.
     *
     * @return void
     */
    public function startHeartbeat()
    {
        if ((null !== Worker::getWorkerID() || Coroutine::stats()['coroutine_num'] > 0) && null !== ($heartbeatInterval = $this->config->getHeartbeatInterval()))
        {
            $this->heartbeatTimerId = \Swoole\Timer::tick($heartbeatInterval * 1000, [$this, 'heartbeat']);
        }
    }

    /**
     * 停止心跳维持资源.
     *
     * @return void
     */
    public function stopHeartbeat()
    {
        if (null !== $this->heartbeatTimerId)
        {
            \Swoole\Timer::clear($this->heartbeatTimerId);
        }
    }
}
