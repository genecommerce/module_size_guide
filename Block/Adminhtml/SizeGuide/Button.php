<?php

declare(strict_types=1);

namespace Gene\SizeGuide\Block\Adminhtml\SizeGuide;

use Magento\Backend\Block\Widget\Context;
use Gene\SizeGuide\Api\SizeGuideRepositoryInterface;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Class Button as a generic class to extend
 */
class Button
{

    /**
     * @var Context
     */
    protected $context;

    /**
     * @var SizeGuideRepositoryInterface
     */
    protected $sizeGuideRepository;

    /**
     * @param Context $context
     * @param SizeGuideRepositoryInterface $sizeGuideRepository
     */
    public function __construct(
        Context $context,
        SizeGuideRepositoryInterface $sizeGuideRepository
    ) {
        $this->context = $context;
        $this->sizeGuideRepository = $sizeGuideRepository;
    }

    /**
     * Return Size Guide ID
     *
     * @return int|null
     */
    public function getSizeGuideId()
    {
        // @codingStandardsIgnoreStart
        try {
            return $this->sizeGuideRepository->getById(
                $this->context->getRequest()->getParam('id')
            )->getId();
        } catch (NoSuchEntityException $e) {
        }
        // @codingStandardsIgnoreEnd
        return null;
    }

    /**
     * Generate url by route and parameters
     *
     * @param   string $route
     * @param   array $params
     * @return  string
     */
    public function getUrl($route = '', $params = [])
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}
