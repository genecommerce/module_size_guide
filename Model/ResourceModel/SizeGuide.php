<?php

declare(strict_types=1);

namespace Gene\SizeGuide\Model\ResourceModel;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Model\ResourceModel\Db\Context;
use Magento\Store\Api\Data\StoreInterface;
use Magento\Store\Model\Store;
use Magento\Store\Model\StoreManagerInterface;
use Gene\SizeGuide\Api\Data\SizeGuideInterface;

class SizeGuide extends AbstractDb
{
    /**
     * Store model
     *
     * @var null|Store
     */
    protected ?Store $_store = null;

    /**
     * Store manager
     *
     * @var StoreManagerInterface
     */
    protected StoreManagerInterface $_storeManager;

    /**
     * @param Context $context
     * @param StoreManagerInterface $storeManager
     * @param string $connectionName
     */
    public function __construct(
        Context $context,
        StoreManagerInterface $storeManager,
        $connectionName = null
    ) {
        parent::__construct($context, $connectionName);
        $this->_storeManager = $storeManager;
    }

    /**
     * Resource initialization
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('gene_sizeguide', 'id');
    }

    /**
     * After main entity has been saved to table save store selection
     * @param AbstractModel $sizeGuide
     * @return AbstractDb
     */
    protected function _afterSave(AbstractModel $sizeGuide): AbstractDb // phpcs:ignore
    {
        $this->saveToStores($sizeGuide);
        return parent::_afterSave($sizeGuide);
    }

    /**
     * Save size guide to associated stores
     * @param $sizeGuide
     * @return $this
     */
    protected function saveToStores($sizeGuide): SizeGuide
    {
        $table = $this->getTable('gene_sizeguide_store');
        if (!$sizeGuide->hasStoreId()) {
            return $this;
        }
        $storeIds = $sizeGuide->getStoreId();
        $oldStoreIds = $this->getStoreIds($sizeGuide);
        $insert = array_diff($storeIds, $oldStoreIds);
        $delete = array_diff($oldStoreIds, $storeIds);
        $connection = $this->getConnection();
        if (!empty($insert)) {
            $data = [];
            foreach ($insert as $storeId) {
                $data[] = [
                    'store_id'    => (int)$storeId,
                    'row_id'     => (int)$sizeGuide->getId()
                ];
            }
            $connection->insertMultiple($table, $data);
        }
        if (!empty($delete)) {
            foreach ($delete as $storeId) {
                $where = ['row_id = ?' => (int)$sizeGuide->getId(), 'store_id = ?' => (int)$storeId];
                $connection->delete($table, $where);
            }
        }
        return $this;
    }

    /**
     * Get store IDs that size guide should be associated to
     * @param \Gene\SizeGuide\Api\Data\SizeGuideInterface $sizeGuide
     * @return array
     */
    public function getStoreIds(SizeGuideInterface $sizeGuide): array
    {
        $connection = $this->getConnection();
        $select = $connection->select()->from(
            $this->getTable('gene_sizeguide_store'),
            'store_id'
        )->where(
            'row_id = ?',
            (int)$sizeGuide->getId()
        );

        return $connection->fetchCol($select);
    }

    /**
     * Get store ids to which specified item is assigned
     * @param $id
     * @return array
     * @throws LocalizedException
     */
    public function lookupStoreIds($id): array
    {
        $connection = $this->getConnection();

        $select = $connection->select()
            ->from(['sss' => $this->getTable('gene_sizeguide_store')], 'store_id')
            ->join(
                ['ss' => $this->getMainTable()],
                'sss.row_id = ss.id',
                []
            )
            ->where('ss.id = :id');

        return $connection->fetchCol($select, ['id' => (int)$id]);
    }

    /**
     * @param $title
     * @return mixed
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function lookupSizeGuideByStore($title)
    {
        $connection = $this->getConnection();
        $storeId = $this->_storeManager->getStore()->getId();
        $select = $connection->select()
            ->from(['sss' => $this->getTable('gene_sizeguide_store')], 'store_id')
            ->join(
                ['ss' => $this->getMainTable()],
                'sss.row_id = ss.id',
                'id'
            )
            ->where('ss.title = ?', (string)$title)
            ->where('sss.store_id = ?', (int)$storeId);

        $query = $select->__toString();
        return $connection->fetchRow($select);
    }

    /**
     * Set store model
     * @param Store $store
     * @return $this
     */
    public function setStore(Store $store): SizeGuide
    {
        $this->_store = $store;
        return $this;
    }

    /**
     * Retrieve store model
     * @return StoreInterface
     * @throws NoSuchEntityException
     */
    public function getStore(): StoreInterface
    {
        return $this->_storeManager->getStore($this->_store);
    }
}
