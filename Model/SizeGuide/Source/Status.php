<?php

declare(strict_types=1);

namespace Gene\SizeGuide\Model\SizeGuide\Source;

use Magento\Framework\Data\OptionSourceInterface;

class Status implements OptionSourceInterface
{
    /**
     * Get options
     *
     * @return array
     */
    public function toOptionArray(): array
    {
        return [
            0 => [
                'label' => 'Enabled',
                'value' => 1
            ],
            1 => [
                'label' => 'Disabled',
                'value' => 0
            ]
        ];
    }
}
