<?php
/**
 * This file is part of Glugox.
 *
 * (c) Glugox <glugox@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace Glugox\Process\Model\ResourceModel;

class Process extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Model Initialization
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('glugox_process', 'id');
    }

    /**
     * Retrieve process by index data fields
     *
     * @param \Magento\Framework\Model\AbstractModel $object
     * @param array $processData
     * @return \Glugox\Process\Model\ResourceModel\Process
     */
    public function getByIndexData( \Magento\Framework\Model\AbstractModel $object, array $processData ){

        $connection = $this->getConnection();
        if ($connection ) {

            $select = $connection->select()->from($this->getMainTable());
            foreach ($processData as $field => $value){
                $field = $connection->quoteIdentifier(sprintf('%s.%s', $this->getMainTable(), $field));
                $select->where($field . '=?', $value);
            }
            $data = $connection->fetchRow($select);
            if ($data) {
                $object->setData($data);
            }
        }
        $this->unserializeFields($object);
        $this->_afterLoad($object);

        return $this;
    }
}
