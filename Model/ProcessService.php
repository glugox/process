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

use Glugox\Process\Api\ProcessServiceInterface;
use Glugox\Process\Model\Process as ProcessModel;
use Glugox\Process\Exception\ProcessException;


/**
 * Process Service.
 *
 * This service is used to interact with processes.
 */
class ProcessService implements ProcessServiceInterface{


    /** @var \Magento\Framework\ObjectManagerInterface */
    protected $_objectManager;
    

    /** @var Process Factory */
    protected $_processFactory;


    protected $_processInstanceService;

    /** @var \Glugox\Process\Helper\Data */
    protected $_helper;
    

    
    public function __construct(
            \Glugox\Process\Model\ProcessFactory $processFactory,
            \Glugox\Process\Model\ProcessInstanceService $processInstanceService,
            \Glugox\Process\Helper\Data $helper
    ) {
        $this->_processFactory = $processFactory;
        $this->_processInstanceService = $processInstanceService;
        $this->_helper = $helper;

    }


    /**
     * @param $code
     * @param array $data
     * @return mixed
     */
    public function getProcess($code, array $data, $forceNew = false) {
        $process = $this->getOrCreate(['code' => $code]);
        $data['process_code'] = $code;
        if($forceNew){
            $processInstance = $this->_processInstanceService->create($data);
        }else{
            $processInstance = $this->_processInstanceService->getOrCreate($data);
        }

        return $processInstance;
    }


    /**
     * @param Instance $process
     * @return Process
     */
    public function startProcess(Instance $process)
    {
        return $this->_helper->startProcess($process);
    }


    /**
     * @param Instance $process
     * @param null $error
     * @return Process
     */
    public function finishProcess(Instance $process, $error = null)
    {
        return $this->_helper->finishProcess($process, $error);
    }


    /**
     * @param Instance $process
     * @param array $data
     * @return Process
     */
    public function updateProcess(Instance $process, $data = [])
    {
        return $this->_helper->updateProcess($process, $data);
    }


    /**
     * @param array $processData
     * @return mixed
     */
    public function create(array $processData) {
        $process = $this->_processFactory->create()->setData($processData);
        $process->save();
        return $process;
    }

    /**
     * @param array $processData
     * @return mixed
     */
    public function getOrCreate(array $processData) {

        $process = $this->_processFactory->create()->getByIndexData($processData);
        if (!$process->getId()) {
            $process = $this->create($processData);
        }

        return $process;
    }
    
    
    /**
     * @param array $processData
     * @return mixed
     * @throws ProcessException
     */
    public function update(array $processData) {
        $process = $this->_loadById($processData['id']);
        $process->addData($processData);
        $process->save();
        return $process;
    }


    /**
     * @param $id
     * @return mixed
     * @throws ProcessException
     */
    public function delete($id) {
        $process = $this->_loadById($id);
        $data = $process->getData();
        $process->delete();
        return $process;
    }


    /**
     * @param $id
     * @return mixed
     * @throws ProcessException
     */
    public function get($id) {
        $process = $this->_loadById($id);
        return $process;
    }


    /**
     * @param $id
     * @return mixed
     * @throws ProcessException
     */
    protected function _loadById($id) {
        $process = $this->_processFactory->create()->load($id);
        if (!$process->getId()) {
            throw new ProcessException(__('Process with ID \'%1\' does not exist.', $id));
        }
        return $process;
    }
    

}
