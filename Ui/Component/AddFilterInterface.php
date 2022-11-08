<?php

declare(strict_types=1);

namespace Gene\SizeGuide\Ui\Component;

use Magento\Framework\Api\Filter;
use Magento\Framework\Api\Search\SearchCriteriaBuilder;

/**
 * Provides extension point to add additional filters to search criteria.
 */
interface AddFilterInterface
{

    /**
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param Filter $filter
     * @return mixed
     */
    public function addFilter(
        SearchCriteriaBuilder $searchCriteriaBuilder,
        Filter $filter
    );
}
