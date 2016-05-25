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


/**
 * Class Instance
 * @package Glugox\Process\Model
 *
 * @method \double getProgress()
 * @method \Glugox\Process\Model\Instance setProgress($value)
 * @method \string getStatusText()
 * @method \Glugox\Process\Model\Instance setStatusText($status)
 * @method \string getStartedAt()
 * @method \Glugox\Process\Model\Instance setStartedAt($value)
 * @method \string getFinishedAt()
 * @method \Glugox\Process\Model\Instance setFinishedAt($value)
 * @method \string getHtmlValueAt()
 * @method \Glugox\Process\Model\Instance setHtmlValue($value)
 * @method \string getName()
 * @method \Glugox\Process\Model\Instance setName($value)
 *  * @method \string getProcessInstanceCode()
 * @method \Glugox\Process\Model\Instance setProcessInstanceCode($value)
 * @method \string getCustomerId()
 * @method \Glugox\Process\Model\Instance setCustomerId($value)
 *
 */
class Instance extends \Magento\Framework\Model\AbstractModel
{

    const PROCESS_INSTANCE_ID = 'id';

    /**
     * Process statusses
     */
    const PROCESS_STATUS_NONE     = 'none';
    const PROCESS_STATUS_RUNNING  = 'running';
    const PROCESS_STATUS_FINISHED = 'finished';
    const PROCESS_STATUS_ERROR    = 'error';

    /**
     * Constructor
     *
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->_init('Glugox\Process\Model\ResourceModel\Instance');
    }


    /**
     * Retrieve process by index data fields
     *
     * @return \Glugox\Process\Model\Instance
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
