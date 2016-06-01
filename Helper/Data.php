<?php

/**
 * This file is part of Glugox.
 *
 * (c) Glugox <glugox@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Glugox\Process\Helper;

use Glugox\Process\Model\Instance;
use Glugox\Process\Model\Process;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;

class Data extends AbstractHelper
{


    /**
     * @var \Magento\Framework\ObjectManagerInterface
     */
    protected $_objectManager;

    /**
     * @var \Magento\Framework\Filesystem
     */
    protected $_filesystem;

    /**
     * @var \Magento\Framework\Filesystem\Directory\WriteInterface
     */
    protected $_pubDirectory;
    


    /**
     * @param Context $context
     */
    public function __construct(
        Context $context,
        \Magento\Framework\ObjectManagerInterface $objectManager,
        \Magento\Framework\Filesystem $filesystem)
    {
        parent::__construct($context);
        $this->_objectManager = $objectManager;
        $this->_filesystem = $filesystem;
        $this->_pubDirectory = $this->_filesystem->getDirectoryWrite(\Magento\Framework\App\Filesystem\DirectoryList::PUB);
    }


    /**
     * @param Process $process
     * @return Process
     */
    public function startProcess( Instance $process ){
        $date = $this->_objectManager->get('Magento\Framework\Stdlib\DateTime\DateTime')->date('Y-m-d H:i:s');
        $process->setStartedAt($date)
            ->setStatusText(Instance::PROCESS_STATUS_RUNNING)
            ->setProgress(0)
            ->save();

        return $process;
    }

    /**
     * @param Process $process
     * @return Process
     */
    public function finishProcess( Instance $process, $error = null ){
        $date = $this->_objectManager->get('Magento\Framework\Stdlib\DateTime\DateTime')->date('Y-m-d H:i:s');
        $processStatus = Instance::PROCESS_STATUS_FINISHED;
        if($error){
            $processStatus = Instance::PROCESS_STATUS_ERROR;
        }
        $process->setFinishedAt($date)
            ->setStatusText($processStatus)
            ->setProgress(100)
            ->save();
        return $process;
    }


    /**
     * @param Process $process
     * @return Process
     */
    public function updateProcess( Instance $process, $data= [] ){

        // updates
        $processStatus = Instance::PROCESS_STATUS_RUNNING;
        if(isset($data['progress']) && (int)$data['progress'] === 100 && !isset($data['status_text'])){
            $processStatus = Instance::PROCESS_STATUS_FINISHED;
            $data['status_text'] = $processStatus;
        }
        if(is_array($data) && !empty($data)){
            $process->addData($data);
        }


        // check for saving
        if($process->hasDataChanges()){

            // save to db
            $process->save();

            // actual save
            //$process = $this->_saveFileUpdate( $process );

            $session = $this->_objectManager->get('Glugox\Process\Model\Session');

            $session->start();
            $session->setProgress($process->getProcessInstanceCode(), $process->getProgress());
            $session->writeClose();

        }

        return $process;
    }


    /**
     * Saves the process to file.
     *
     * @param Instance $process
     * @return Instance
     */
    /*protected function _saveFileUpdate( Instance $process ){

        // save to file
        $processInstanceCode = $process->getProcessInstanceCode();
        $jsString = "define([],function(){return {$process->toJson()} })";
        $this->_pubDirectory->writeFile("process/{$processInstanceCode}.js", $jsString);

        return $process;
    }*/




}