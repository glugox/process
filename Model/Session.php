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
 * Process session model
 * @method string getNoReferer()
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class Session extends \Magento\Framework\Session\SessionManager
{


    /**
     * @var \Magento\Framework\Session\Generic
     */
    protected $_session;


    /**
     * Session constructor.
     * @param \Magento\Framework\App\Request\Http $request
     * @param \Magento\Framework\Session\SidResolverInterface $sidResolver
     * @param \Magento\Framework\Session\Config\ConfigInterface $sessionConfig
     * @param \Magento\Framework\Session\SaveHandlerInterface $saveHandler
     * @param \Magento\Framework\Session\ValidatorInterface $validator
     * @param \Magento\Framework\Session\StorageInterface $storage
     * @param \Magento\Framework\Stdlib\CookieManagerInterface $cookieManager
     * @param \Magento\Framework\Stdlib\Cookie\CookieMetadataFactory $cookieMetadataFactory
     * @param \Magento\Framework\App\State $appState
     */
    public function __construct(
        \Magento\Framework\App\Request\Http $request,
        \Magento\Framework\Session\SidResolverInterface $sidResolver,
        \Magento\Framework\Session\Config\ConfigInterface $sessionConfig,
        \Magento\Framework\Session\SaveHandlerInterface $saveHandler,
        \Magento\Framework\Session\ValidatorInterface $validator,
        \Magento\Framework\Session\StorageInterface $storage,
        \Magento\Framework\Stdlib\CookieManagerInterface $cookieManager,
        \Magento\Framework\Stdlib\Cookie\CookieMetadataFactory $cookieMetadataFactory,
        \Magento\Framework\App\State $appState,
        \Magento\Framework\Session\Generic $session
    ) {

        parent::__construct(
            $request,
            $sidResolver,
            $sessionConfig,
            $saveHandler,
            $validator,
            $storage,
            $cookieManager,
            $cookieMetadataFactory,
            $appState
        );

    }

    /**
     * @param $processCode
     * @return int
     */
    public function getProgress($processCode){
        $key = 'process_' . $processCode;
        if ($this->storage->getData($key)) {
            return (int)$this->storage->getData($key);
        }

        return 0;
    }


    /**
     * @param $processId
     * @param $progress
     */
    public function setProgress($processCode, $progress){
        $key = 'process_' . $processCode;
        $this->storage->setData($key, $progress);
    }



}
