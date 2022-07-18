<?php

declare(strict_types=1);

namespace Gene\SizeGuide\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Controller\ResultFactory;

class Index extends Action
{

    /**
     * Admin listing page controller
     *
     * @return ResultInterface|ResponseInterface
     */
    public function execute()
    {
        return $this->resultFactory->create(ResultFactory::TYPE_PAGE);
    }

    /**
     * @return bool
     */
    protected function _isAllowed() // phpcs:ignore
    {
        return $this->_authorization->isAllowed('Sunspel_SizeGuide::menu_sizeguide_create_edit');
    }
}
