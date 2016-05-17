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

use Glugox\Process\Model\Instance as InstanceModel;
use Glugox\Process\Exception\ProcessException;


/**
 * Process Instance Service.
 *
 * This service is used to interact with processes.
 */
class ProcessInstanceService{


    /** @var \Magento\Framework\ObjectManagerInterface */
    protected $_objectManager;
    

    /** @var Process Instance Factory */
    protected $_processInstanceFactory;

    /** @var \Glugox\Process\Helper\Data */
    protected $_helper;


    /**
     * ProcessInstanceService constructor.
     * @param InstanceFactory $processInstanceFactory
     * @param \Glugox\Process\Helper\Data $helper
     */
    public function __construct(
            \Glugox\Process\Model\InstanceFactory $processInstanceFactory,
            \Glugox\Process\Helper\Data $helper
    ) {
        $this->_processInstanceFactory = $processInstanceFactory;
        $this->_helper = $helper;

    }
    


    /**
     * @param array $instanceData
     * @return mixed
     */
    public function create(array $instanceData) {
        $instance = $this->_processInstanceFactory->create()->setData($instanceData);
        $instance->save();
        return $instance;
    }

    /**
     * @param array $instanceData
     * @return mixed
     */
    public function getOrCreate(array $instanceData) {

        $instance = $this->_processInstanceFactory->create()->getByIndexData($instanceData);
        if (!$instance->getId()) {
            $instance = $this->create($instanceData);
        }

        return $instance;
    }
    
    
    /**
     * @param array $instanceData
     * @return mixed
     * @throws ProcessException
     */
    public function update(array $instanceData) {
        $instance = $this->_loadById($instanceData['id']);
        $instance->addData($instanceData);
        $instance->save();
        return $instance;
    }


    /**
     * @param $id
     * @return mixed
     * @throws ProcessException
     */
    public function delete($id) {
        $instance = $this->_loadById($id);
        $data = $instance->getData();
        $instance->delete();
        return $instance;
    }


    /**
     * @param $id
     * @return mixed
     * @throws ProcessException
     */
    public function get($id) {
        $instance = $this->_loadById($id);
        return $instance;
    }


    /**
     * @param $id
     * @return mixed
     * @throws ProcessException
     */
    protected function _loadById($id) {
        $instance = $this->_processInstanceFactory->create()->load($id);
        if (!$instance->getId()) {
            throw new ProcessException(__('Process with ID \'%1\' does not exist.', $id));
        }
        return $instance;
    }
    

}
