<?php

declare(strict_types=1);

namespace Gene\SizeGuide\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;
use Gene\SizeGuide\Api\SizeGuideRepositoryInterface;
use Gene\SizeGuide\Model\SizeGuide;
use Gene\SizeGuide\Model\SizeGuideFactory;

class Save extends Action
{

    /**
     * @var SizeGuideRepositoryInterface
     */
    private $sizeGuideRepository;

    /**
     * @var SizeGuideFactory
     */
    private $factory;

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
     * @return ResultInterface|ResponseInterface
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        /** \Gene\SizeGuide\Model\SizeGuide $sizeGuide */
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
            $this->messageManager->addSuccessMessage(__('Size guide saved.'));
            return $this->processResultRedirect($result, $data);
        } catch (\Exception $e) {
            $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving.'));
            return $result->setUrl($this->_redirect->getRefererUrl());
        }
    }

    /**
     * Process result redirect
     * @param Redirect $resultRedirect
     * @param array $data
     * @return Redirect
     */
    private function processResultRedirect($resultRedirect, $data)
    {
        if ($this->getRequest()->getParam('back', false) === 'duplicate') {
            $newSizeGuide = $this->factory->create(['data' => $data]);
            $newSizeGuide->setId(null);
            $this->sizeGuideRepository->save($newSizeGuide);
            $this->messageManager->addSuccessMessage(__('You duplicated the page.'));
        }
        return $resultRedirect->setPath('*/*/index');
    }

    /**
     * @return bool
     */
    protected function _isAllowed() // phpcs:ignore
    {
        return $this->_authorization->isAllowed('Sunspel_SizeGuide::menu_sizeguide_create_edit');
    }
}
