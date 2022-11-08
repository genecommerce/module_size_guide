<?php

declare(strict_types=1);

namespace Gene\SizeGuide\Model;

use Magento\Framework\Exception\LocalizedException;
use Gene\SizeGuide\Api\Data\SizeGuideInterface;
use Gene\SizeGuide\Api\SizeGuideRepositoryInterface;
use Gene\SizeGuide\Model\ResourceModel\SizeGuide;
use Gene\SizeGuide\Model\SizeGuideFactory;
use Gene\SizeGuide\Model\ResourceModel\SizeGuide\CollectionFactory;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Store\Model\StoreManagerInterface;

/**
 * phpcs:disable Magento2.CodeAnalysis.EmptyBlock.DetectedCatch
 */
class SizeGuideRepository implements SizeGuideRepositoryInterface
{
    /**
     * @var SizeGuide
     */
    protected SizeGuide $resource;

    /**
     * @var SizeGuideFactory
     */
    protected \Gene\SizeGuide\Model\SizeGuideFactory $factory;

    /**
     * @var CollectionFactory
     */
    protected CollectionFactory $collectionFactory;

    /** @var StoreManagerInterface */
    protected StoreManagerInterface $storeManager;

    /**
     * SizeGuideRepository constructor.
     * @param SizeGuide $resource
     * @param SizeGuideFactory $factory
     * @param CollectionFactory $collectionFactory
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        SizeGuide $resource,
        SizeGuideFactory $factory,
        CollectionFactory $collectionFactory,
        StoreManagerInterface $storeManager
    ) {
        $this->resource = $resource;
        $this->factory = $factory;
        $this->collectionFactory = $collectionFactory;
        $this->storeManager = $storeManager;
    }

    /**
     * @param SizeGuideInterface $guide
     * @return SizeGuideInterface
     * @throws CouldNotSaveException
     */
    public function save(SizeGuideInterface $guide): SizeGuideInterface
    {
        try {
            $this->resource->save($guide); // @phpstan-ignore-line
        } catch (\Exception $e) {
            throw new CouldNotSaveException(__($e->getMessage()));
        }
        return $guide;
    }

    /**
     * @param $id
     * @return mixed
     * @throws NoSuchEntityException
     */
    public function getById($id)
    {
        $sizeGuide = $this->factory->create();
        $this->resource->load($sizeGuide, $id);
        if (!$sizeGuide->getId()) {
            throw new NoSuchEntityException(__('The size guide with an ID of %1 doesn\'t exist.', $id));
        }
        return $sizeGuide;
    }

    /**
     * @param $title
     * @return mixed
     */
    public function getByTitle($title)
    {
        $sizeGuide = $this->factory->create();
        try {
            $guide = $this->resource->lookupSizeGuideByStore($title);
        } catch (NoSuchEntityException|LocalizedException $e) {
            // @todo: Add logger or thrown exception.
        }
        if (isset($guide['id'])) {
            $this->resource->load($sizeGuide, $guide['id']);
        }
        if (!$sizeGuide->getId()) {
            return false;
        }
        return $sizeGuide;
    }

    /**
     * @param SizeGuideInterface $guide
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(SizeGuideInterface $guide)
    {
        try {
            $this->resource->delete($guide); // @phpstan-ignore-line
        } catch (\Exception $e) {
            throw new CouldNotDeleteException(__($e->getMessage()));
        }
        return true;
    }
}
