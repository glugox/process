<?php
/**
 * This file is part of Glugox.
 *
 * (c) Glugox <glugox@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace Glugox\Process\Controller\Adminhtml\Instance;

class NewAction extends \Glugox\Process\Controller\Adminhtml\Instance
{

    public function execute()
    {
        $this->_forward('edit');
    }
}
