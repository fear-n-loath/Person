<?php

namespace Elogic\Person\Model;

use Magento\Framework\Api\SearchResults;
use Magento\Framework\Api\SearchResultsInterfaceFactory;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Elogic\Person\Api\PersonRepositoryInterface;
use Elogic\Person\Api\Data\PersonInterface;
use Elogic\Person\Model\ResourceModel\Person\Collection;
use Elogic\Person\Model\ResourceModel\Person as PersonResource;
use Elogic\Person\Model\ResourceModel\Person\Collection as PersonCollectionFactory;

/**
 * Class PersonRepository
 */
class PersonRepository implements PersonRepositoryInterface
{
    /**
     * @var PersonModelFactory
     */
    private $personModelFactory;

    /**
     * @var PersonCollectionFactory
     */
    private $personCollectionFactory;

    /**
     * @var PersonResource
     */
    private $resource;

    /**
     * @type SearchResultsInterfaceFactory
     */
    private $searchResultsFactory;

    /**
     * @type CollectionProcessorInterface
     */
    private $collectionProcessor;

    /**
     * @param PersonModelFactory $personModelFactory
     * @param PersonCollectionFactory $personCollectionFactory
     * @param PersonResource $resource
     * @param SearchResultsInterfaceFactory $searchResultsFactory
     * @param CollectionProcessorInterface $collectionProcessor
     */
    public function __construct(
        PersonModelFactory $personModelFactory,
        PersonCollectionFactory $personCollectionFactory,
        PersonResource $resource,
        SearchResultsInterfaceFactory $searchResultsFactory,
        CollectionProcessorInterface $collectionProcessor
    ) {
        $this->personModelFactory = $personModelFactory;
        $this->personCollectionFactory = $personCollectionFactory;
        $this->resource = $resource;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->collectionProcessor = $collectionProcessor;
    }

    /**
     * @inheritDoc
     * @throws CouldNotSaveException
     */
    public function save(PersonInterface $person): PersonInterface
    {
        try {
            /** @var  PersonModel|PersonInterface $person */
            $this->resource->save($person);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }

        return $person;
    }

    /**
     * @inheritDoc
     * @throws NoSuchEntityException
     */
    public function getById(int $personId): PersonInterface
    {
        /** @var  PersonModel|PersonInterface $person */
        $person = $this->personModelFactory->create();
        $person->load($personId);
        if (!$person->getId()) {
            throw new NoSuchEntityException(__('Person entity with id `%1` does not exist.' . $personId, $personId));
        }

        return $person;
    }

    /**
     * @inheritDoc
     */
    public function getList(SearchCriteriaInterface $criteria): SearchResults
    {
        /** @var Collection $collection */
        $collection = $this->personCollectionFactory->create();
        $this->collectionProcessor->process($criteria, $collection);

        /** @var SearchResults $searchResults */
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    /**
     * @inheritDoc
     * @throws CouldNotDeleteException
     */
    public function delete(PersonInterface $person): bool
    {
        try {
            /** @var PersonModel $person */
            $this->resource->delete($person);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }

        return true;
    }

    /**
     * @inheritDoc
     * @throws CouldNotDeleteException
     */
    public function deleteById(int $personId): bool
    {
        try {
            $delete = $this->delete($this->getById($personId));
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }
        return $delete;
    }
}
