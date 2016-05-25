<?php
/**
 * This file is part of Glugox.
 *
 * (c) Glugox <glugox@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Glugox\Process\Block;


use Magento\Framework\App\Filesystem\DirectoryList;

class ProcessBlock extends \Magento\Framework\View\Element\Template
{


    /**
     * @var \Glugox\Process\Helper\Data
     */
    protected $_helper;

    /**
     * @var \Magento\Framework\Math\Random
     */
    protected $_random;


    /**
     * @var \Magento\Framework\Filesystem
     */
    protected $_filesystem;


    /**
     * @var \Magento\Framework\Filesystem\Directory\WriteInterface
     */
    protected $_pubDirectory;

    /**
     * ProcessBlock constructor.
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Glugox\Process\Helper\Data $helper
     * @param array $data
     */
    public function __construct(
            \Magento\Framework\Registry $registry,
            \Magento\Framework\View\Element\Template\Context $context,
            \Glugox\Process\Helper\Data $helper,
            \Magento\Framework\Math\Random $random,
            \Magento\Framework\Filesystem $filesystem,
            array $data = array()
            ) {

        $this->_helper = $helper;
        $this->_random = $random;
        $this->_filesystem = $filesystem;
        $this->_pubDirectory = $this->_filesystem->getDirectoryWrite(\Magento\Framework\App\Filesystem\DirectoryList::PUB);


        parent::__construct($context, $data);
    }


    /**
     * @return string
     */
    public function getProcessAjaxUrl(){
        return $this->getUrl("process/index/progress");
    }


    /**
     * @return string
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getHashBase(){
        return $this->_random->getRandomString(30);
    }


    /**
     * @return \Magento\Framework\Filesystem\Directory\ReadInterface
     */
    public function getTempDir(){
        return "/" . DirectoryList::PUB . '/' . 'process' . '/';
    }



}
