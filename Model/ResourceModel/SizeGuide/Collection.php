<?php

declare(strict_types=1);

namespace Gene\SizeGuide\Model\ResourceModel\SizeGuide;

use Magento\Framework\Data\Collection\Db\FetchStrategyInterface;
use Magento\Framework\Data\Collection\EntityFactoryInterface;
use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\Event\ManagerInterface;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Gene\SizeGuide\Model\ResourceModel\SizeGuide;

class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'id';

    /**
     * @var string
     */
    protected $_eventPrefix = 'size_guide_collection';

    /**
     * @var string
     */
    protected $_eventObject = 'size_guide_collection';

    /**
     * Collection constructor.
     * @param EntityFactoryInterface $entityFactory
     * @param \Psr\Log\LoggerInterface $logger
     * @param FetchStrategyInterface $fetchStrategy
     * @param ManagerInterface $eventManager
     * @param AdapterInterface|null $connection
     * @param AbstractDb|null $resource
     */
    // @codingStandardsIgnoreStart
    public function __construct(
        EntityFactoryInterface $entityFactory,
        \Psr\Log\LoggerInterface $logger,
        FetchStrategyInterface $fetchStrategy,
        ManagerInterface $eventManager,
        AdapterInterface $connection = null,
        AbstractDb $resource = null
    ) {
        parent::__construct(
            $entityFactory,
            $logger,
            $fetchStrategy,
            $eventManager,
            $connection,
            $resource
        );
    }
    // @codingStandardsIgnoreEnd

    /**
     * Define resource modeL
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            \Gene\SizeGuide\Model\SizeGuide::class,
            SizeGuide::class
        );
    }

    /**
     * Allow filtering by store id
     * @return AbstractCollection|void
     */
    protected function _initSelect()                          // phpcs:ignore
    {
        return parent::_initSelect();
    }

    /**
     * @param $storeId
     * @return $this
     */
    public function addStoreFilter($storeId)
    {
        $this->getSelect()
            ->where('`store_id` = ?', $storeId);

        return $this;
    }
}
