<?php

declare(strict_types=1);

namespace Gene\SizeGuide\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultFactory;

class Edit extends \Magento\Backend\App\Action implements \Magento\Framework\App\Action\HttpGetActionInterface
{
    /**
     * @var \Gene\SizeGuide\Api\SizeGuideRepositoryInterface
     */
    private \Gene\SizeGuide\Api\SizeGuideRepositoryInterface $sizeGuideRepository;

    /**
     * @var \Magento\Framework\Registry
     */
    private \Magento\Framework\Registry $registry;

    /**
     * Edit constructor.
     * @param Action\Context $context
     * @param \Gene\SizeGuide\Api\SizeGuideRepositoryInterface $repository
     * @param \Magento\Framework\Registry $registry
     */
    public function __construct(
        Action\Context $context,
        \Gene\SizeGuide\Api\SizeGuideRepositoryInterface $repository,
        \Magento\Framework\Registry $registry
    ) {
        parent::__construct($context);
        $this->sizeGuideRepository = $repository;
        $this->registry = $registry;
    }

    /**
     * Edit Guide Controller
     *
     * @return \Magento\Framework\Controller\ResultInterface|ResponseInterface
     * @throws \Magento\Framework\Exception\NotFoundException
     */
    public function execute()
    {
        $params = $this->getRequest()->getParams();
        $result = $this->resultRedirectFactory->create();

        if (isset($params['id'])) {
            $sizeGuide = $this->sizeGuideRepository->getById($params['id']);
            if (!$sizeGuide->getId()) {
                $this->messageManager->addErrorMessage(__('This record no longer exists.')); // @phpstan-ignore-line
                return $result->setUrl($this->_redirect->getRefererUrl());
            }
            $this->registry->register('size_guide', $sizeGuide);
        }

        return $this->resultFactory->create(ResultFactory::TYPE_PAGE);
    }

    /**
     * @return bool
     */
    protected function _isAllowed(): bool // phpcs:ignore
    {
        return $this->_authorization->isAllowed('Gene_SizeGuide::menu_sizeguide_create_edit');
    }
}
