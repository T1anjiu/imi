<?php

namespace Imi\Test\Component\Model;

use Imi\Model\Annotation\Column;
use Imi\Model\Annotation\Entity;
use Imi\Model\Annotation\RedisEntity;
use Imi\Model\RedisModel;

/**
 * Test.
 *
 * @Entity
 * @RedisEntity(key="{id}-{name}")
 *
 * @property int    $id
 * @property string $name
 * @property int    $age
 */
class TestRedisModel extends RedisModel
{
    /**
     * id.
     *
     * @Column(name="id")
     *
     * @var int
     */
    protected $id;

    /**
     * get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * assignment id.
     *
     * @param int $id id
     *
     * @return static
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * name.
     *
     * @Column(name="name")
     *
     * @var string
     */
    protected $name;

    /**
     * get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * assignment name.
     *
     * @param string $name name
     *
     * @return static
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * age.
     *
     * @Column(name="age")
     *
     * @var string
     */
    protected $age;

    /**
     * get age.
     *
     * @return string
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * assignment age.
     *
     * @param string $age age
     *
     * @return static
     */
    public function setAge($age)
    {
        $this->age = $age;

        return $this;
    }
}
