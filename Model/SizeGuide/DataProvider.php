<?php

declare(strict_types=1);

namespace Gene\SizeGuide\Model\SizeGuide;

use Gene\SizeGuide\Model\ResourceModel\SizeGuide\Collection;
use Gene\SizeGuide\Model\ResourceModel\SizeGuide\CollectionFactory;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Ui\DataProvider\Modifier\PoolInterface;
use Magento\Ui\DataProvider\ModifierPoolDataProvider;
use Gene\SizeGuide\Model\SizeGuide;

class DataProvider extends ModifierPoolDataProvider
{
    /**
     * @var Collection
     */
    protected $collection;

    /**
     * @var DataPersistorInterface
     */
    protected DataPersistorInterface $dataPersistor;

    /**
     * @var array
     */
    protected array $loadedData;

    /**
     * Constructor
     *
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $sizeGuideCollectionFactory
     * @param DataPersistorInterface $dataPersistor
     * @param array $meta
     * @param array $data
     * @param PoolInterface|null $pool
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $sizeGuideCollectionFactory,
        DataPersistorInterface $dataPersistor,
        array $meta = [],
        array $data = [],
        PoolInterface $pool = null
    ) {
        $this->collection = $sizeGuideCollectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data, $pool);
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData(): array
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }

        $this->loadedData = [];
        $items = $this->collection;

        /** @var SizeGuide $guide */
        foreach ($items as $guide) {
            $this->loadedData[$guide->getId()] = $guide->getData();
            $this->loadedData[$guide->getId()]['store_id'] = $guide->getStoreId();
        }

        // @todo: Figure out why this is here
        if (!empty($data)) {
            $guide = $this->collection->getNewEmptyItem();
            $guide->setData($data);
            $this->loadedData[$guide->getId()] = $guide->getData();
        }

        return $this->loadedData;
    }
}
