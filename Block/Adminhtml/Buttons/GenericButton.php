<?php
declare(strict_types=1);

namespace Elogic\Person\Block\Adminhtml\Buttons;

use Elogic\Person\Api\Data\PersonInterface;
use Elogic\Person\Api\PersonRepositoryInterface;
use Magento\Backend\Block\Widget\Context;
use Magento\Framework\Logger\Handler\Exception;

/**
 * Class GenericButton
 */
class GenericButton
{
    /**
     * @var Context
     */
    private Context $context;

    /**
     * @var PersonRepositoryInterface
     */
    private PersonRepositoryInterface $personRepository;

    /**
     * @param Context $context
     * @param PersonRepositoryInterface $personRepository
     */
    public function __construct(
        Context $context,
        PersonRepositoryInterface $personRepository
    ) {
        $this->context = $context;
        $this->personRepository = $personRepository;
    }

    /**
     * @return int|null
     */
    public function getRowId(): ?int
    {
        try {
            $request = $this->context->getRequest();
            $rowID = (int)$request->getParam(PersonInterface::ENTITY_ID);
            return (int)$this->personRepository->getById($rowID)->getId();
        } catch (Exception $e) {
            return null;
        }
    }

    /**
     * Generate url by route and parameters
     *
     * @param string $route
     * @param array $params
     * @return  string
     */
    public function getUrl(string $route = '', array $params = []): string
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}
