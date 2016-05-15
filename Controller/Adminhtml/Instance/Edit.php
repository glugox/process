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

class Edit extends \Glugox\Process\Controller\Adminhtml\Instance
{

    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
        $model = $this->_objectManager->create('Glugox\Process\Model\Instance');

        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                $this->messageManager->addError(__('This process instance no longer exists.'));
                $this->_redirect('glugox_process/*');
                return;
            }
        }
        // set entered data if was error when we do save
        $data = $this->_objectManager->get('Magento\Backend\Model\Session')->getPageData(true);
        if (!empty($data)) {
            $model->addData($data);
        }
        $this->_coreRegistry->register('current_glugox_process_instance', $model);
        $this->_initAction();
        $this->_view->getLayout()->getBlock('process_instance_edit');
        $this->_view->renderLayout();
    }
}
