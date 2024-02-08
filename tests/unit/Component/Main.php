<?php

namespace Imi\Test\Component;

use Imi\Test\AppBaseMain;
use Imi\Util\File;
use Imi\Util\Imi;

class Main extends AppBaseMain
{
    /**
     * @return void
     */
    public function __init()
    {
        // You can do some initialization operations here, if necessary
        parent::__init();
        $path = Imi::getRuntimePath('test');
        if (is_dir($path))
        {
            File::deleteDir($path);
        }
    }
}
