<?php

namespace Imi\Test\Component\Model\Base;

use Imi\Model\Annotation\Column;
use Imi\Model\Annotation\DDL;
use Imi\Model\Annotation\Entity;
use Imi\Model\Annotation\Table;
use Imi\Model\Model as Model;

/**
 * tb_member Base Class.
 *
 * @Entity
 * @Table(name="tb_member", id={"id"})
 * @DDL("CREATE TABLE `tb_member` (   `id` int(10) unsigned NOT NULL AUTO_INCREMENT,   `username` varchar(32) NOT NULL COMMENT 'USERNAME',   `password` varchar(255) NOT NULL COMMENT 'PASSWORD',   PRIMARY KEY (`id`) USING BTREE ) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT")
 *
 * @property int    $id
 * @property string $username username
 * @property string $password password
 */
abstract class MemberBase extends Model
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
     * username.
     *
     * @Column(name="username", type="varchar", length=32, accuracy=0, nullable=false, default="", isPrimaryKey=false, primaryKeyIndex=-1, isAutoIncrement=false)
     *
     * @var string
     */
    protected $username;

    /**
     * get username.
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * assignment username.
     *
     * @param string $username username
     *
     * @return static
     */
    public function setUsername($username)
    {
        if (mb_strlen($username) > 32)
        {
            throw new \InvalidArgumentException('The maximum length of $username is 32');
        }
        $this->username = $username;

        return $this;
    }

    /**
     * 
     * password.
     *
     * @Column(name="password", type="varchar", length=255, accuracy=0, nullable=false, default="", isPrimaryKey=false, primaryKeyIndex=-1, isAutoIncrement=false)
     *
     * @var string
     */
    protected $password;

    /**
     * get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * assignment password
     *
     * @param string $password password
     *
     * @return static
     */
    public function setPassword($password)
    {
        if (mb_strlen($password) > 255)
        {
            throw new \InvalidArgumentException('The maximum length of $password is 255');
        }
        $this->password = $password;

        return $this;
    }
}
