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

class Index extends \Glugox\Process\Controller\Adminhtml\Instance
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
        $resultPage->setActiveMenu('Glugox_Process::instance');
        $resultPage->getConfig()->getTitle()->prepend(__('Process Instances'));
        $resultPage->addBreadcrumb(__('Process Instances'), __('Process Instances'));
        return $resultPage;
    }
}
