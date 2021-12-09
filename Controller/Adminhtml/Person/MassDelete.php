<?php
declare(strict_types=1);

namespace Elogic\Person\Controller\Adminhtml\Person;

use Elogic\Person\Api\Data\PersonInterface;
use Elogic\Person\Api\PersonRepositoryInterface;
use Elogic\Person\Model\ResourceModel\Person\Collection as PersonCollection;
use Elogic\Person\Model\ResourceModel\Person\CollectionFactory as PersonResourceCollectionFactory;
use Exception;
use Magento\Backend\App\Action as BackendAction;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Ui\Component\MassAction\Filter;

/**
 * Class MassDelete
 * @package Elogic\Person\Controller\Adminhtml\Person
 */
class MassDelete extends BackendAction implements HttpPostActionInterface
{
    /**
     * {@inheritdoc}
     */
    const ADMIN_RESOURCE = 'Elogic_Person::person_mass_delete';

    /**
     * @var DataPersistorInterface
     */
    private DataPersistorInterface $dataPersistor;

    /**
     * @var PersonRepositoryInterface
     */
    private PersonRepositoryInterface $personRepository;

    /**
     * @var Filter
     */
    private Filter $filter;

    /**
     * @var PersonResourceCollectionFactory
     */
    private PersonResourceCollectionFactory $collectionFactory;

    /**
     * @param Context $context
     * @param PersonRepositoryInterface $personRepository
     * @param PersonResourceCollectionFactory $collectionFactory
     * @param Filter $filter
     * @param DataPersistorInterface $dataPersist
     */
    public function __construct(
        Context $context,
        PersonRepositoryInterface $personRepository,
        PersonResourceCollectionFactory $collectionFactory,
        Filter $filter,
        DataPersistorInterface $dataPersist
    ) {
        $this->dataPersistor = $dataPersist;
        $this->filter = $filter;
        $this->personRepository = $personRepository;
        $this->collectionFactory = $collectionFactory;
        parent::__construct($context);
    }

    /**
     * @return ResultInterface
     */
    public function execute(): ResultInterface
    {
        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();

        try {
            /** @var PersonCollection $collection */
            $collection = $this->filter->getCollection($this->collectionFactory->create());
            $count = 0;
            foreach ($collection as $person) {
                /** @var PersonInterface $person */
                if ($this->personRepository->delete($person)) {
                    $count++;
                }
            }
            $message = __('A total of %1 record(s) have been deleted.', $count);
            $this->messageManager->addSuccessMessage($message);
            $this->dataPersistor->clear('row');
            return $resultRedirect->setPath('*/*/');
        } catch (NoSuchEntityException | LocalizedException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        } catch (Exception $e) {
            $this->messageManager->addExceptionMessage($e, __('Something went wrong while deleting rows.'));
        }
        return $resultRedirect->setPath('*/*/');
    }
}
