<?php
declare(strict_types=1);

namespace Elogic\Person\Controller\Adminhtml\Person;

use Elogic\Person\Api\Data\PersonInterface;
use Elogic\Person\Api\PersonRepositoryInterface;
use Elogic\Person\Model\PersonModelFactory;
use Magento\Backend\App\Action as BackendAction;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\App\Request\Http as HttpRequest;
use Magento\Framework\Controller\ResultInterface;

/**
 * Class Save
 * @package Elogic\Person\Controller\Adminhtml\Person
 */
class Save extends BackendAction implements HttpPostActionInterface
{
    /**
     * {@inheritdoc}
     */
    const ADMIN_RESOURCE = 'Elogic_person::person_save';

    /**
     * @var DataPersistorInterface
     */
    private DataPersistorInterface $dataPersist;

    /**
     * @var PersonRepositoryInterface
     */
    private PersonRepositoryInterface $personRepository;

    /**
     * @var PersonModelFactory
     */
    private PersonModelFactory $personFactory;

    /**
     * @param Context $context
     * @param PersonRepositoryInterface $personRepository
     * @param PersonModelFactory $personFactory
     * @param DataPersistorInterface $dataPersist
     */
    public function __construct(
        Context $context,
        PersonRepositoryInterface $personRepository,
        PersonModelFactory $personFactory,
        DataPersistorInterface $dataPersist
    ) {
        $this->dataPersist = $dataPersist;
        $this->personRepository = $personRepository;
        $this->personFactory = $personFactory;
        parent::__construct($context);
    }

    /**
     * @return ResultInterface
     */
    public function execute(): ResultInterface
    {
        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();

        /** @var HttpRequest $request */
        $request = $this->getRequest();
        $data = $request->getPostValue();
        if ($data) {
            $id = $this->getRequest()->getParam(PersonInterface::ENTITY_ID);
            if (empty($data[PersonInterface::ENTITY_ID])) {
                $data[PersonInterface::ENTITY_ID] = null;
            }

            if ($id) {
                /** @var PersonInterface $model */
                $model = $this->personRepository->getById((int)$id);
            } else {
                /** @var PersonInterface $model */
                $model = $this->personFactory->create();
            }
            $model->setData($data);

            try {
                $this->personRepository->save($model);
                $this->messageManager->addSuccessMessage(__('You saved the row.'));
                $this->dataPersist->clear('row');
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', [PersonInterface::ENTITY_ID => $model->getId()]);
                }

                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the row.'));
            }

            $this->dataPersist->set('vendor', $data);
            return $resultRedirect->setPath('*/*/edit', [PersonInterface::ENTITY_ID => $id]);
        }
        return $resultRedirect->setPath('*/*/');
    }
}
