<?php

namespace Gene\SizeGuide\Model\ResourceModel\SizeGuide\Relation\Store;

use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\EntityManager\Operation\ExtensionInterface;
use Gene\SizeGuide\Model\ResourceModel\SizeGuide;
use Magento\Framework\EntityManager\MetadataPool;
use Magento\Framework\App\ResourceConnection;

class SaveHandler implements ExtensionInterface
{
    /**
     * @var MetadataPool
     */
    protected MetadataPool $metadataPool;

    /**
     * @var ResourceConnection
     */
    protected ResourceConnection $resourceConnection;

    /**
     * @var SizeGuide
     */
    protected SizeGuide $resourceSizeGuide;

    /**
     * @param MetadataPool $metadataPool
     * @param ResourceConnection $resourceConnection
     * @param SizeGuide $resourceSizeGuide
     */
    public function __construct(
        MetadataPool $metadataPool,
        ResourceConnection $resourceConnection,
        SizeGuide $resourceSizeGuide
    ) {
        $this->metadataPool = $metadataPool;
        $this->resourceConnection = $resourceConnection;
        $this->resourceSizeGuide = $resourceSizeGuide;
    }

    /**
     * @param object $entity
     * @param array $arguments
     * @return object
     * @throws \Exception
     */
    public function execute(
        $entity,
        $arguments = []
    ): object {
        /** @var AdapterInterface $connection */
        $connection = $this->resourceConnection->getConnectionByName(null); // @phpstan-ignore-line
        $oldStores = $this->resourceSizeGuide->lookupStoreIds((int)$entity->getId());
        $newStores = (array)$entity->getStores();
        if (empty($newStores)) {
            $newStores = (array)$entity->getStoreId();
        }

        $table = $this->resourceSizeGuide->getTable('gene_sizeguide_store');

        $delete = array_diff($oldStores, $newStores);
        if ($delete) {
            $where = [
                'row_id = ?' => (int)$entity->getData('id'),
                'store_id IN (?)' => $delete,
            ];
            $connection->delete($table, $where);
        }

        $insert = array_diff($newStores, $oldStores);
        if ($insert) {
            $data = [];
            foreach ($insert as $storeId) {
                $data[] = [
                    'row_id' => (int)$entity->getData('id'),
                    'store_id' => (int)$storeId
                ];
            }
            $connection->insertMultiple($table, $data);
        }

        return $entity;
    }
}
