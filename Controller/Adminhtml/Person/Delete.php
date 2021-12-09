<?php
declare(strict_types=1);

namespace Elogic\Person\Controller\Adminhtml\Person;

use Exception;
use Magento\Backend\App\Action as BackendAction;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Controller\ResultInterface;
use Elogic\Person\Api\Data\PersonInterface;
use Elogic\Person\Api\PersonRepositoryInterface;

/**
 * Class Delete
 * @package Elogic\Person\Controller\Adminhtml\Person
 */
class Delete extends BackendAction implements HttpGetActionInterface
{
    /**
     * {@inheritdoc}
     */
    const ADMIN_RESOURCE = 'Elogic_Person::person_delete';

    /**
     * @var DataPersistorInterface
     */
    private DataPersistorInterface $dataPersist;

    /**
     * @var PersonRepositoryInterface
     */
    private PersonRepositoryInterface $personRepository;

    /**
     * @param Context $context
     * @param PersonRepositoryInterface $personRepository
     * @param DataPersistorInterface $dataPersist
     */
    public function __construct(
        Context $context,
        PersonRepositoryInterface $personRepository,
        DataPersistorInterface $dataPersist
    ) {
        $this->dataPersist = $dataPersist;
        $this->personRepository = $personRepository;
        parent::__construct($context);
    }

    /**
     * @return ResultInterface
     */
    public function execute(): ResultInterface
    {
        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $id = (int)$this->getRequest()->getParam(PersonInterface::ENTITY_ID);

        try {
            $this->personRepository->deleteById($id);
            $this->messageManager->addSuccessMessage(__('You deleted the row'));
            $this->dataPersist->clear('row');
            return $resultRedirect->setPath('*/*/');
        } catch (Exception $e) {
            $this->messageManager->addExceptionMessage($e, __('Something went wrong while deleting the row.'));
        }
        return $resultRedirect->setPath('*/*/');
    }
}
