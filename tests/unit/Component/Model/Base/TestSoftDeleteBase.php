<?php

namespace Imi\Test\Component\Model\Base;

use Imi\Model\Annotation\Column;
use Imi\Model\Annotation\DDL;
use Imi\Model\Annotation\Entity;
use Imi\Model\Annotation\Table;
use Imi\Model\Model as Model;

/**
 * tb_test_soft_delete Base Class.
 *
 * @Entity
 * @Table(name="tb_test_soft_delete", id={"id"})
 * @DDL("CREATE TABLE `tb_test_soft_delete` (   `id` int(10) unsigned NOT NULL AUTO_INCREMENT,   `title` varchar(255) NOT NULL,   `delete_time` int(10) unsigned NOT NULL DEFAULT '0',   PRIMARY KEY (`id`) ) ENGINE=InnoDB DEFAULT CHARSET=utf8")
 *
 * @property int    $id
 * @property string $title
 * @property int    $deleteTime
 */
abstract class TestSoftDeleteBase extends Model
{
    /**
     * id.
     *
     * @Column(name="id", type="int", length=10, accuracy=0, nullable=false, default="", isPrimaryKey=true, primaryKeyIndex=0, isAutoIncrement=true)
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
     * title.
     *
     * @Column(name="title", type="varchar", length=255, accuracy=0, nullable=false, default="", isPrimaryKey=false, primaryKeyIndex=-1, isAutoIncrement=false)
     *
     * @var string
     */
    protected $title;

    /**
     * get title.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * assignment title.
     *
     * @param string $title title
     *
     * @return static
     */
    public function setTitle($title)
    {
        if (mb_strlen($title) > 255)
        {
            throw new \InvalidArgumentException('The maximum length of $title is 255');
        }
        $this->title = $title;

        return $this;
    }

    /**
     * delete_time.
     *
     * @Column(name="delete_time", type="int", length=10, accuracy=0, nullable=false, default="0", isPrimaryKey=false, primaryKeyIndex=-1, isAutoIncrement=false)
     *
     * @var int
     */
    protected $deleteTime;

    /**
     * get deleteTime.
     *
     * @return int
     */
    public function getDeleteTime()
    {
        return $this->deleteTime;
    }

    /**
     * assignment deleteTime.
     *
     * @param int $deleteTime delete_time
     *
     * @return static
     */
    public function setDeleteTime($deleteTime)
    {
        $this->deleteTime = $deleteTime;

        return $this;
    }
}
