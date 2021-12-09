<?php
declare(strict_types=1);

namespace Elogic\Person\Model;

use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Ui\DataProvider\AbstractDataProvider;
use Elogic\Person\Api\Data\PersonInterface;
use Elogic\Person\Model\ResourceModel\Person\CollectionFactory;
use Elogic\Person\Model\ResourceModel\Person\Collection;

/**
 * Class DataProvider
 * @package Elogic\Person\Model
 */
class DataProvider extends AbstractDataProvider
{
    /**
     * @var CollectionFactory
     */
    protected CollectionFactory $collectionFactory;

    /**
     * @var DataPersistorInterface
     */
    protected DataPersistorInterface $dataPersists;

    /**
     * @var array|null
     */
    protected $loadedData;

    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $weatherCollectionFactory
     * @param DataPersistorInterface $dataPersists
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $weatherCollectionFactory,
        DataPersistorInterface $dataPersists,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->collectionFactory = $weatherCollectionFactory;
        $this->dataPersists = $dataPersists;
        $this->collection = $this->collectionFactory->create();
    }

    /**
     * {@inheritDoc}
     */
    public function getData()
    {
        /** @var Collection $collection */
        $this->collection = $this->collectionFactory->create();

        if ($this->loadedData === null) {
            $this->loadedData = [];
            $items = $this->collection->getItems();
            /** @var PersonInterface $row */
            foreach ($items as $row) {
                $this->loadedData[$row->getId()] = $this->prepareData($row);
            }
            $data = $this->dataPersists->get('rows');
            if (!empty($data)) {
                $row = $this->collection->getNewEmptyItem();
                $row->setData($data);
                $this->loadedData[$row->getId()] = $this->prepareData($row);
                $this->dataPersists->clear('rows');
            }
        }
        return $this->loadedData;
    }

    /**
     * @param PersonInterface $row
     * @return array
     */
    private function prepareData(PersonInterface $row): array
    {
        return $row->getData();
    }
}
