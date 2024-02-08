<?php

namespace Imi\Test\Component\Model\Base;

use Imi\Model\Annotation\Column;
use Imi\Model\Annotation\DDL;
use Imi\Model\Annotation\Entity;
use Imi\Model\Annotation\Table;
use Imi\Model\Model as Model;

/**
 * tb_test_json Base Class.
 *
 * @Entity
 * @Table(name="tb_test_json", id={"id"})
 * @DDL("CREATE TABLE `tb_test_json` (   `id` int(10) unsigned NOT NULL AUTO_INCREMENT,   `json_data` json NOT NULL COMMENT 'jsonData',   PRIMARY KEY (`id`) ) ENGINE=InnoDB DEFAULT CHARSET=utf8")
 *
 * @property int                       $id
 * @property \Imi\Util\LazyArrayObject $jsonData jsonData
 */
abstract class TestJsonBase extends Model
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
     * 
     * json_data.
     *
     * @Column(name="json_data", type="json", length=0, accuracy=0, nullable=false, default="", isPrimaryKey=false, primaryKeyIndex=-1, isAutoIncrement=false)
     *
     * @var \Imi\Util\LazyArrayObject
     */
    protected $jsonData;

    /**
     * get jsonData
     *
     * @return \Imi\Util\LazyArrayObject
     */
    public function getJsonData()
    {
        return $this->jsonData;
    }

    /**
     * get jsonData
     *
     * @param \Imi\Util\LazyArrayObject $jsonData json_data
     *
     * @return static
     */
    public function setJsonData($jsonData)
    {
        $this->jsonData = $jsonData;

        return $this;
    }
}
