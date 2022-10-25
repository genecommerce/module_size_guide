<?php

declare(strict_types=1);

namespace Gene\SizeGuide\Model\Config\Source;

use Gene\SizeGuide\Model\ResourceModel\SizeGuide\Collection;
use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;
use Magento\Eav\Model\Entity\Attribute\Source\SourceInterface;
use Magento\Framework\Data\OptionSourceInterface;

class ChartTypes extends AbstractSource
{

    /**
     * @var array
     */
    protected array $options;

    /**
     * @var Collection
     */
    private Collection $collection;

    /**
     * @param \Gene\SizeGuide\Model\ResourceModel\SizeGuide\Collection $collection
     */
    public function __construct(
        Collection $collection
    ) {
        $this->collection = $collection;
    }

    /**
     * @return array
     */
    public function toOptionArray(): array
    {
        if (empty($this->options)) {
            $collection = $this->collection->addFieldToSelect('id')
                ->addFieldToSelect('title')
                ->addFieldToFilter('status', ['eq' => '1']);

            $options[] = [
                'label' => 'Select',
                'value' => ''
            ];

            foreach ($collection as $item) {
                $options[] = [
                    'label' => $item->getTitle(),
                    'value' => $item->getId()
                ];
            }

            $this->options = $options;
        }
        return $this->options;
    }

    /**
     * @return array
     */
    public function getAllOptions(): array
    {
        return $this->toOptionArray();
    }
}
