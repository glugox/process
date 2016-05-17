<?php

/**
 * This file is part of Glugox.
 *
 * (c) Glugox <glugox@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Glugox\Process\Console\Command;

use Glugox\Process\Api\ProcessServiceInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\StringInput;
use Magento\Framework\App\Filesystem\DirectoryList;


/**
 * Class ListCommand
 */
class ListCommand extends Command {


    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_registry = null;


    protected $_processService;

    /**
     *
     * @param \Magento\Framework\Registry $registry
     */
    public function __construct(\Magento\Framework\Registry $registry, ProcessServiceInterface $processService) {

        $this->_registry = $registry;
        $this->_processService = $processService;
        parent::__construct();
    }


    /**
     * {@inheritdoc}
     */
    protected function configure() {
        $this->setName('glugox:process:list')
                ->setDescription('Lists processes.')
                ->setDefinition(
                    new \Symfony\Component\Console\Input\InputDefinition([])
                );
        parent::configure();
    }


    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output) {

        $output->writeln('<info>Processes list...</info>');

        $process = $this->_processService->getProcess("glugox-pdf-test", ["name" => "Test ! Creating pdf for sku: 890748.", "store_id" => 0]);
        $process->setProgress(98)->save();



    }


}
