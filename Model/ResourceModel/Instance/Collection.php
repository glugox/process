<?php
/**
 * This file is part of Glugox.
 *
 * (c) Glugox <glugox@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Glugox\Process\Model\ResourceModel\Instance;

use Glugox\Process\Model\Instance;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{


    /**
     * @var string
     */
    protected $_idFieldName = Instance::PROCESS_INSTANCE_ID;

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Glugox\Process\Model\Instance', 'Glugox\Process\Model\ResourceModel\Instance');
    }
}
