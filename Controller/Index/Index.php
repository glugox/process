<?php

/**
 * This file is part of Glugox.
 *
 * (c) Glugox <glugox@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Glugox\Process\Controller\Index;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Session\SessionManager;


/**
 * Controller.
 */
class Index extends \Magento\Framework\App\Action\Action {


    /**
     * @var \Glugox\Process\Model\ProcessInstanceService
     */
    protected $_processInstanceService;

    /**
     * @var \Magento\Framework\Json\Helper\Data
     */
    protected $_jsonHelper;


    /**
     * @var \Glugox\Process\Model\Session
     */
    protected $_processSession;

    /**
     * @param Context $context
     */
    public function __construct(
        Context $context,
        \Glugox\Process\Model\ProcessInstanceService $processInstanceService,
        \Magento\Framework\Json\Helper\Data $jsonHelper,
        \Glugox\Process\Model\Session $processSession
    )
    {
        parent::__construct($context);
        $this->_processInstanceService = $processInstanceService;
        $this->_jsonHelper = $jsonHelper;
        $this->_processSession = $processSession;
    }


    /**
     * Process info
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute() {

        $processInstanceCode = $this->getRequest()->getParam('process_instance_code', 'default');

        $this->_processSession->setProgress($processInstanceCode, 0);
        $this->_processSession->writeClose();
        sleep(8);

        $this->_processSession->start();
        $this->_processSession->setProgress($processInstanceCode, 20);
        $this->_processSession->writeClose();
        sleep(8);

        $this->_processSession->start();
        $this->_processSession->setProgress($processInstanceCode, 40);
        $this->_processSession->writeClose();
        sleep(8);

        $this->_processSession->start();
        $this->_processSession->setProgress($processInstanceCode, 60);
        $this->_processSession->writeClose();
        sleep(8);

        $this->_processSession->start();
        $this->_processSession->setProgress($processInstanceCode, 80);
        $this->_processSession->writeClose();
        sleep(8);

        $this->_processSession->start();
        $this->_processSession->setProgress($processInstanceCode, 100);
        $this->_processSession->writeClose();


        $jsonResult = $this->_jsonHelper->jsonEncode(['process' => 0]);
        return $this->getResponse()->representJson($jsonResult);
        
    }


}
