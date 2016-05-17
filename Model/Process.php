<?php
/**
 * This file is part of Glugox.
 *
 * (c) Glugox <glugox@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace Glugox\Process\Model;

use Glugox\Process\Api\ProcessInterface;

class Process extends \Magento\Framework\Model\AbstractModel
{

    /**
     * Constructor
     *
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->_init('Glugox\Process\Model\ResourceModel\Process');
    }

    /**
     * @param array $processData
     * @return \Glugox\Process\Model\Process
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getByIndexData( array $processData ){

        $this->_beforeLoad(\implode(",", \array_values($processData)), \implode(",", \array_keys($processData)));
        $this->_getResource()->getByIndexData($this, $processData);
        $this->_afterLoad();
        $this->setOrigData();
        $this->_hasDataChanges = false;

        // update stored data. method is private
        if (isset($this->_data)) {
            $this->storedData = $this->_data;
        } else {
            $this->storedData = [];
        }

        return $this;
    }
}
