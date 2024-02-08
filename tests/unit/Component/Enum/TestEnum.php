<?php

namespace Imi\Test\Component\Enum;

use Imi\Enum\Annotation\EnumItem;
use Imi\Enum\BaseEnum;

class TestEnum extends BaseEnum
{
    /**
     * @EnumItem(text="A", other="a1")
     */
    const A = 1;

    /**
     * @EnumItem(text="B", other="b2")
     */
    const B = 2;

    /**
     * @EnumItem(text="C", other="c3")
     */
    const C = 3;
}
