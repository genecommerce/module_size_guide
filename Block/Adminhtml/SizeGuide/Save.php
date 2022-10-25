<?php

declare(strict_types=1);

namespace Gene\SizeGuide\Block\Adminhtml\SizeGuide;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;
use Magento\Ui\Component\Control\Container;

class Save extends Button implements ButtonProviderInterface
{
    /**
     * @return array
     */
    public function getButtonData(): array
    {
        return [
            'label' => __('Save'),
            'class' => 'save primary',
            'data_attribute' => [
                'mage-init' => [
                    'buttonAdapter' => [
                        'actions' => [
                            [
                                'targetName' => 'size_guide_form.size_guide_form',
                                'actionName' => 'save',
                                'params' => [
                                    true,
                                    [
                                        'back' => 'continue'
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ],
            'class_name' => Container::SPLIT_BUTTON,
            'options' => $this->getOptions(),
        ];
    }

    /**
     * Retrieve options
     *
     * @return array
     */
    private function getOptions(): array
    {
        return
            [
                [
                    'label' => __('Save & Duplicate'),
                    'id_hard' => 'save_and_duplicate',
                    'data_attribute' => [
                        'mage-init' => [
                            'buttonAdapter' => [
                                'actions' => [
                                    [
                                        'targetName' => 'size_guide_form.size_guide_form',
                                        'actionName' => 'save',
                                        'params' => [
                                            true,
                                            [
                                                'back' => 'duplicate'
                                            ]
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ]
                ],
                [
                    'id_hard' => 'save_and_close',
                    'label' => __('Save & Close'),
                    'data_attribute' => [
                        'mage-init' => [
                            'buttonAdapter' => [
                                'actions' => [
                                    [
                                        'targetName' => 'size_guide_form.size_guide_form',
                                        'actionName' => 'save',
                                        'params' => [
                                            true,
                                            [
                                                'back' => 'close'
                                            ]
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ];
    }
}
