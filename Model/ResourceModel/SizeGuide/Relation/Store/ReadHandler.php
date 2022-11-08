<?php

namespace Gene\SizeGuide\Model\ResourceModel\SizeGuide\Relation\Store;

use Magento\Framework\Exception\LocalizedException;
use Gene\SizeGuide\Model\ResourceModel\SizeGuide;
use Magento\Framework\EntityManager\MetadataPool;
use Magento\Framework\EntityManager\Operation\ExtensionInterface;

class ReadHandler implements ExtensionInterface
{
    /**
     * @var MetadataPool
     */
    protected MetadataPool $metadataPool;

    /**
     * @var SizeGuide
     */
    protected SizeGuide $resourceSizeGuide;

    /**
     * @param MetadataPool $metadataPool
     * @param SizeGuide $resourceSizeGuide
     */
    public function __construct(
        MetadataPool $metadataPool,
        SizeGuide $resourceSizeGuide
    ) {
        $this->metadataPool = $metadataPool;
        $this->resourceSizeGuide = $resourceSizeGuide;
    }

    /**
     * @param object $entity
     * @param array $arguments
     * @return object
     * @throws LocalizedException
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function execute(
        $entity,
        $arguments = []
    ): object {
        if ($entity->getId()) {
            $stores = $this->resourceSizeGuide->lookupStoreIds((int)$entity->getId());
            $entity->setData('store_id', $stores);
        }
        return $entity;
    }
}
