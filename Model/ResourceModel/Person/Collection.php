<?php

namespace Elogic\Person\Model\ResourceModel\Person;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Elogic\Person\Model\PersonModel;
use Elogic\Person\Model\ResourceModel\Person as PersonResourceModel;

/**
 * Class Collection
 */
class Collection extends AbstractCollection
{
    /**
     * {@inheritdoc}
     */
    protected $_idFieldName = PersonModel::ENTITY_ID;

    /**
     * {@inheritdoc}
     */
    protected function _construct()
    {
        $this->_init(
            PersonModel::class,
            PersonResourceModel::class
        );
    }
}
