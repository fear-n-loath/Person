<?php
declare(strict_types=1);

namespace Elogic\Person\Block;

use Elogic\Person\Api\PersonRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResults;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

/**
 * Class Personlist
 * @package Person\Weather\Block
 */
class PersonList extends Template
{
    /**
     * @var PersonRepositoryInterface
     */
    private PersonRepositoryInterface $personRepository;

    /**
     * PersonList constructor.
     * @param Context $context
     * @param PersonRepositoryInterface $personRepository
     */
    public function __construct(
        Context $context,
        PersonRepositoryInterface $personRepository,
        SearchCriteriaInterface $searchCriteria,
    ) {
        $this->personRepository = $personRepository;
        parent::__construct($context);
    }


    /**
     * @return SearchResults
     */
    public function getPersons(): SearchResults
    {
       // $searchCriteria = $this->create();
       // return $this->personRepository->getList($searchCriteria);
        $searchResult = "";
        try {
            $searchResult = $this->personRepository->getList($this->searchCriteria);
        } catch (\Exception $exception) {
            $this->_logger->critical($exception->getMessage());
        }
        return $searchResult;
    }
}
