<?php

namespace Elogic\Person\Api;

use Elogic\Person\Api\Data\PersonInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResults;

/**
 * Interface PersonRepositoryInterface
 */
interface PersonRepositoryInterface
{
    /**
     * @param PersonInterface $person
     * @return PersonInterface
     */
    public function save(PersonInterface $person): PersonInterface;

    /**
     * @param int $personId
     * @return PersonInterface
     */
    public function getById(int $personId): PersonInterface;

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return SearchResults
     */
    public function getList(SearchCriteriaInterface $searchCriteria): SearchResults;

    /**
     * @param PersonInterface $person
     * @return bool
     */
    public function delete(PersonInterface $person): bool;

    /**
     * @param int $personId
     * @return bool
     */
    public function deleteById(int $personId): bool;
}
