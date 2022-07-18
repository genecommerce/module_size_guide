<?php

declare(strict_types=1);

namespace Gene\SizeGuide\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultFactory;

class Edit extends \Magento\Backend\App\Action implements \Magento\Framework\App\Action\HttpGetActionInterface
{

    /**
     * @var Gene\SizeGuide\Model\SizeGuideFactory
     */
    private $sizeGuideFactory;

    /**
     * @var \Gene\SizeGuide\Api\SizeGuideRepositoryInterface
     */
    private $sizeGuideRepository;

    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    private $resultPageFactory;

    /**
     * @var \Magento\Framework\Registry
     */
    private $registry;

    /**
     * Edit constructor.
     * @param Action\Context $context
     * @param \Gene\SizeGuide\Model\SizeGuideFactory $sizeGuideFactory
     * @param \Gene\SizeGuide\Api\SizeGuideRepositoryInterface $repository
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Magento\Framework\Registry $registry
     */
    public function __construct(
        Action\Context $context,
        \Gene\SizeGuide\Model\SizeGuideFactory $sizeGuideFactory,
        \Gene\SizeGuide\Api\SizeGuideRepositoryInterface $repository,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\Registry $registry
    ) {
        parent::__construct($context);
        $this->sizeGuideFactory = $sizeGuideFactory;
        $this->sizeGuideRepository = $repository;
        $this->resultPageFactory = $resultPageFactory;
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
                $this->messageManager->addErrorMessage(__('This record no longer exists.'));
                return $result->setUrl($this->_redirect->getRefererUrl());
            }
        }

        $this->registry->register('size_guide', $sizeGuide);
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
