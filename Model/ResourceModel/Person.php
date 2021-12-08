<?php

namespace Elogic\Person\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Elogic\Person\Model\PersonModel;

class Person extends AbstractDb
{
    const PERSON = 'person';

    /**
     * {@inheritdoc}
     */
    protected function _construct()
    {
        $this->_init(
            self::PERSON,
            PersonModel::ENTITY_ID
        );
    }
}
