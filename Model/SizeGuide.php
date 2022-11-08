<?php

declare(strict_types=1);

namespace Gene\SizeGuide\Model;

use Magento\Framework\Model\AbstractModel;
use Gene\SizeGuide\Model\ResourceModel\SizeGuide as SizeGuideResource;
use Gene\SizeGuide\Api\Data\SizeGuideInterface;

class SizeGuide extends AbstractModel implements SizeGuideInterface
{

    /**
     * Initialize resource model
     */
    protected function _construct()
    {
        $this->_init(SizeGuideResource::class);
    }

    /**
     * Receive page store ids
     *
     * @return int[]
     */
    public function getStores(): array
    {
        return $this->hasData('stores') ? $this->getData('stores') : (array)$this->getData('store_id');
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->getData(self::ID);
    }

    /**
     * @param mixed $id
     * @return AbstractModel|SizeGuide
     */
    public function setId($id)
    {
        return $this->setData(self::ID, $id);
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->getData(self::STATUS);
    }

    /**
     * @param $status
     * @return SizeGuide
     */
    public function setStatus($status): SizeGuide
    {
        return $this->setData(self::STATUS, $status);
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->getData(self::TITLE);
    }

    /**
     * @param $title
     * @return SizeGuide
     */
    public function setTitle($title): SizeGuide
    {
        return $this->setData(self::TITLE, $title);
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->getData(self::CONTENT);
    }

    /**
     * @param $content
     * @return SizeGuide
     */
    public function setContent($content): SizeGuide
    {
        return $this->setData(self::CONTENT, $content);
    }

    /**
     * @return mixed
     */
    public function getTableIn()
    {
        return $this->getData(self::TABLE_IN);
    }

    /**
     * @param $tableIn
     * @return SizeGuide
     */
    public function setTableIn($tableIn): SizeGuide
    {
        return $this->setData(self::TABLE_IN, $tableIn);
    }

    /**
     * @return mixed
     */
    public function getTableCm()
    {
        return $this->getData(self::TABLE_CM);
    }

    /**
     * @param $tableCm
     * @return SizeGuide
     */
    public function setTableCm($tableCm): SizeGuide
    {
        return $this->setData(self::TABLE_CM, $tableCm);
    }

    /**
     * @return array|int[]
     */
    public function getStoreId(): array
    {
        if (!$this->hasData(self::STORE_ID)) {
            $ids = $this->getResource()->getStoreIds($this); // @phpstan-ignore-line
            $this->setData(self::STORE_ID, $ids);
        }
        return (array)$this->_getData(self::STORE_ID);
    }

    /**
     * @param int[] $storeId
     * @return SizeGuideInterface|SizeGuide
     */
    public function setStoreId(array $storeId): SizeGuideInterface
    {
        return $this->setData(self::STORE_ID, $storeId);
    }
}
