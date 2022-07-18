<?php

declare(strict_types=1);

namespace Gene\SizeGuide\Block;

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Registry;
use Magento\Framework\View\Element\Template;
use Gene\SizeGuide\Model\SizeGuideRepository;
use Magento\Cms\Model\Template\FilterProvider;

class SizeGuide extends Template
{
    /**
     * @var Registry
     */
    private $registry;

    /**
     * @var \Gene\SizeGuide\Model\SizeGuide
     */
    private $sizeChart;

    /**
     * @var SizeGuideRepository
     */
    private $repository;

    /**
     * @var FilterProvider $filterProvider
     */
    private $filterProvider;

    /**
     * SizeGuide constructor.
     * @param Template\Context $context
     * @param Registry $registry
     * @param SizeGuideRepository $repository
     * @param FilterProvider $filterProvider
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        Registry $registry,
        SizeGuideRepository $repository,
        FilterProvider $filterProvider,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->registry = $registry;
        $this->repository = $repository;
        $this->filterProvider = $filterProvider;
        $this->setBodyClass();
    }

    /**
     * Product attribute size guide selected over sku named size guide
     * @return mixed|\Gene\SizeGuide\Model\SizeGuide
     * @throws NoSuchEntityException
     */
    public function getSizeChart()
    {
        $currentProduct = $this->getCurrentProduct();
        if (!$currentProduct) {
            return;
        }

        if ($currentProduct->getData('size_chart')) {
            $this->sizeChart = $this->repository->getById($currentProduct->getData('size_chart'));
            return $this->sizeChart;
        } else {
            $sizeChart = $this->repository->getByTitle($currentProduct->getSku());
            if ($sizeChart instanceof \Gene\SizeGuide\Model\SizeGuide) {
                $this->sizeChart = $sizeChart;
                return $this->sizeChart;
            }
        }
    }

    /**
     * @return mixed
     */
    protected function getCurrentProduct()
    {
        return $this->registry->registry('product');
    }

    /**
     * @return mixed
     */
    public function getSizeGuideTitle()
    {
        return $this->sizeChart->getTitle();
    }

    /**
     * @return int
     */
    public function getSizeGuideStore()
    {
        // @todo need to look up in store table
        return $this->sizeChart->getId();
    }

    /**
     * @return mixed
     */
    public function getRecommendedSizeTableHtml()
    {
        return $this->sizeChart->getTableCm();
    }

    /**
     * @return mixed
     */
    public function getProductMesaurmentsTableHtml()
    {
        return $this->sizeChart->getTableIn();
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function getAdditionalContentHtml()
    {
        return $this->filterProvider->getPageFilter()->filter(
            $this->sizeChart->getContent()
        );
    }

    /**
     * Set Body Class on page
     */
    public function setBodyClass()
    {
        if ($this->getSizeChart()) {
            $this->pageConfig->addBodyClass('has-size-chart');
        }
    }
}
