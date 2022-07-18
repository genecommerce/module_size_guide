<?php

declare(strict_types=1);

namespace Gene\SizeGuide\Model\Config\Source;

use Gene\SizeGuide\Model\ResourceModel\SizeGuide\Collection;
use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;
use Magento\Eav\Model\Entity\Attribute\Source\SourceInterface;
use Magento\Framework\Data\OptionSourceInterface;

class ChartTypes extends AbstractSource implements SourceInterface, OptionSourceInterface
{

    /**
     * @var array
     */
    protected $options;

    /**
     * @var Collection
     */
    private $collection;

    public function __construct(
        Collection $collection
    ) {
        $this->collection = $collection;
    }

    /**
     * @return array
     */
    public function toOptionArray()
    {
        if ($this->options === null) {
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

    public function getAllOptions()
    {
        return $this->toOptionArray();
    }
}
