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
     * @param Context $context
     */
    public function __construct(Context $context, \Magento\Framework\ObjectManagerInterface $objectManager)
    {
        parent::__construct($context);
        $this->_objectManager = $objectManager;
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


}