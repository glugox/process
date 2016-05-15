<?php

/**
 * This file is part of Glugox.
 *
 * (c) Glugox <glugox@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Glugox\Process\Setup;

use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

/**
 * @codeCoverageIgnore
 */
class UpgradeSchema implements UpgradeSchemaInterface {

    /**
     * {@inheritdoc}
     */
    public function upgrade(SchemaSetupInterface $setup,
            ModuleContextInterface $context) {

        $installer = $setup;
        $installer->startSetup();


        $connection = $installer->getConnection();

        $processTableName = $installer->getTable('glugox_process');
        $processInstanceTableName = $installer->getTable('glugox_process_instance');

        /**
         * Create table processes definitions
         */
        $table = $connection->newTable(
            $processTableName
        )->addColumn(
            'id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
            'Process Id'
        )->addColumn(
            'code',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            [],
            'Process Code'
        )->addColumn(
            'name',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            [],
            'Process Name'
        )->addIndex(
            $installer->getIdxName(
                'glugox_process',
                ['code'],
                \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_UNIQUE
            ),
            ['code'],
            ['type' => \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_UNIQUE]
        )->setComment(
            'Processes Definitions'
        );
        $connection->createTable($table);



        /**
         * Create table processes instances
         */
        $table = $connection->newTable(
            $processInstanceTableName
        )->addColumn(
            'id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
            'Process Instance Id'
        )->addColumn(
            'process_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            ['unsigned' => true, 'nullable' => false, 'default' => '0'],
            'Process Id'
        )->addColumn(
            'store_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            null,
            ['unsigned' => true, 'nullable' => false, 'default' => '0'],
            'Store Id'
        )->addColumn(
            'plain_value',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            '64k',
            [],
            'Plain Text Value'
        )->addColumn(
            'html_value',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            '64k',
            [],
            'Html Value'
        )->addIndex(
            $installer->getIdxName(
                'glugox_process_instance',
                ['id', 'store_id'],
                \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_UNIQUE
            ),
            ['id', 'store_id'],
            ['type' => \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_UNIQUE]
        )->addIndex(
            $installer->getIdxName('glugox_process_instance', ['store_id']),
            ['store_id']
        )->setComment(
            'Process Instance'
        );
        $connection->createTable($table);


        /**
         * Foreign keys
         */

        /**
         * Foreign key : store :: store_id (store_id)
         */
        $connection->addForeignKey(
            $installer->getFkName('glugox_process_instance', 'store_id', 'store', 'store_id'),
            $processInstanceTableName,
            'store_id',
            $installer->getTable('store'),
            'store_id',
            \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
        );

        /**
         * Foreign key : glugox_process :: id (process_id)
         */
        $connection->addForeignKey(
            $installer->getFkName('glugox_process_instance', 'process_id', 'variable', 'process_id'),
            $processInstanceTableName,
            'process_id',
            $installer->getTable('glugox_process'),
            'id',
            \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
        );

        $installer->endSetup();
    }


}
