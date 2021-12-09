<?php
declare(strict_types=1);

namespace Elogic\Person\Controller\Adminhtml\Person;

use Elogic\Person\Api\Data\PersonInterface;
use Elogic\Person\Api\PersonRepositoryInterface;
use Magento\Backend\App\Action as BackendAction;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Controller\ResultInterface;

/**
 * Class InlineEdit
 * @package Elogic\Person\Controller\Adminhtml\Person
 */
class InlineEdit extends BackendAction implements HttpPostActionInterface
{
    /**
     * {@inheritdoc}
     */
    const ADMIN_RESOURCE = 'Elogic_Person::person_inline_edit';

    /**
     * @var JsonFactory
     */
    private JsonFactory $jsonFactory;

    /**
     * @var PersonRepositoryInterface
     */
    private PersonRepositoryInterface $personRepository;

    /**
     * @param Context $context
     * @param PersonRepositoryInterface $personRepository
     * @param JsonFactory $jsonFactory
     */
    public function __construct(
        Context $context,
        PersonRepositoryInterface $personRepository,
        JsonFactory $jsonFactory
    ) {
        $this->personRepository = $personRepository;
        $this->jsonFactory = $jsonFactory;
        parent::__construct($context);
    }

    /**
     * @return ResultInterface
     */
    public function execute(): ResultInterface
    {
        $resultJson = $this->jsonFactory->create();
        $error = false;
        $messages = [];

        if ($this->getRequest()->getParam('isAjax')) {
            $postItems = $this->getRequest()->getParam('items', []);
            if (empty($postItems)) {
                $messages[] = __('Please correct the data sent.');
                $error = true;
            } else {
                foreach (array_keys($postItems) as $id) {
                    try {
                        /** @var PersonInterface $model */
                        $model = $this->personRepository->getById((int)$id);
                        $model->setData(array_merge($model->getData(), $postItems[$id]));
                        $this->personRepository->save($model);
                    } catch (\Exception $e) {
                        $messages[] = $e->getMessage();
                        $error = true;
                    }
                }
            }
        }
        return $resultJson->setData([
            'messages' => $messages,
            'error' => $error
        ]);
    }
}
