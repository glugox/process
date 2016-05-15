<?php
/**
 * This file is part of Glugox.
 *
 * (c) Glugox <glugox@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace Glugox\Process\Controller\Adminhtml\Process;

class Index extends \Glugox\Process\Controller\Adminhtml\Process
{
    /**
     * Process list.
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Glugox_Process::process');
        $resultPage->getConfig()->getTitle()->prepend(__('Processes'));
        $resultPage->addBreadcrumb(__('Processes'), __('Processes'));
        return $resultPage;
    }
}
