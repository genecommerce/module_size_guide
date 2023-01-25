<?php

declare(strict_types=1);

namespace Gene\SizeGuide\Controller\Adminhtml\Index;

use Exception;
use Magento\Backend\App\Action;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Gene\SizeGuide\Api\SizeGuideRepositoryInterface;
use Gene\SizeGuide\Model\SizeGuideFactory;

class Save extends Action
{
    /**
     * @var SizeGuideRepositoryInterface
     */
    private SizeGuideRepositoryInterface $sizeGuideRepository;

    /**
     * @var SizeGuideFactory
     */
    private SizeGuideFactory $factory;

    /**
     * Save constructor.
     * @param Action\Context $context
     * @param SizeGuideRepositoryInterface $repository
     * @param SizeGuideFactory $factory
     */
    public function __construct(
        Action\Context $context,
        SizeGuideRepositoryInterface $repository,
        SizeGuideFactory $factory
    ) {
        parent::__construct($context);
        $this->sizeGuideRepository = $repository;
        $this->factory = $factory;
    }

    /**
     * Save guide controller
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    public function execute(): Redirect
    {
        $data = $this->getRequest()->getPostValue(); // @phpstan-ignore-line
        /** @var \Gene\SizeGuide\Model\SizeGuide $sizeGuide */
        $sizeGuide = $this->factory->create();

        if (isset($data['id']) && $data['id'] !== '') {
            $sizeGuide->setId($data['id']);
        }

        $sizeGuide->setStatus($data['status']);
        $sizeGuide->setContent($data['content']);
        $sizeGuide->setTableCm($data['table_cm']);
        $sizeGuide->setTableIn($data['table_in']);
        $sizeGuide->setTitle($data['title']);
        $sizeGuide->setStoreId($data['store_id']);

        /** @var Redirect $result */
        $result = $this->resultRedirectFactory->create();

        try {
            $this->sizeGuideRepository->save($sizeGuide);
            $this->messageManager->addSuccessMessage(__('Size guide saved.')); // @phpstan-ignore-line
            return $this->processResultRedirect($result, $data);
        } catch (Exception $e) {
            $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving.')); // @phpstan-ignore-line
            return $result->setUrl($this->_redirect->getRefererUrl());
        }
    }

    /**
     * Process result redirect
     * @param Redirect $resultRedirect
     * @param array $data
     * @return Redirect
     */
    private function processResultRedirect(
        Redirect $resultRedirect,
        array $data
    ): Redirect {
        if ($this->getRequest()->getParam('back', false) === 'duplicate') {
            $newSizeGuide = $this->factory->create(['data' => $data]);
            $newSizeGuide->setId(null);
            $this->sizeGuideRepository->save($newSizeGuide);
            $this->messageManager->addSuccessMessage(__('You duplicated the page.')); // @phpstan-ignore-line
        }
        return $resultRedirect->setPath('*/*/index');
    }

    /**
     * @return bool
     */
    protected function _isAllowed(): bool // phpcs:ignore
    {
        return $this->_authorization->isAllowed('Gene_SizeGuide::menu_sizeguide_create_edit');
    }
}
