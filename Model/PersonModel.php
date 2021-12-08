<?php

namespace Elogic\Person\Model;

use Elogic\Person\Api\Data\PersonInterface;
use Magento\Framework\Model\AbstractModel;
use Elogic\Person\Model\ResourceModel\Person as PersonResourceModel;

/**
 * Class Person Model
 */
class PersonModel extends AbstractModel implements PersonInterface
{
    public function _construct()
    {
        $this->_init(PersonResourceModel::class);
    }

    /**
     * @inheritDoc
     */
    public function getId()
    {
        return $this->getData(self::ENTITY_ID);
    }

    /**
     * @inheritDoc
     */
    public function getName()
    {
        return $this->getData(self::NAME);
    }

    /**
     * @inheritDoc
     */
    public function getSurname()
    {
        return $this->getData(self::SURNAME);
    }

    /**
     * @inheritDoc
     */
    public function getAge()
    {
        return $this->getData(self::AGE);
    }

    /**
     * @inheritDoc
     */
    public function getGender()
    {
        return $this->getData(self::GENDER);
    }

    /**
     * @inheritDoc
     */
    public function getContent()
    {
        return $this->getData(self::CONTENT);
    }

    /**
     * @inheritDoc
     */
    public function setName($name): PersonInterface
    {
        return $this->setData(self::NAME, $name);
    }

    /**
     * @inheritDoc
     */
    public function setSurname($surname): PersonInterface
    {
        return $this->setData(self::SURNAME, $surname);
    }

    /**
     * @inheritDoc
     */
    public function setAge($age): PersonInterface
    {
        return $this->setData(self::AGE, $age);
    }

    /**
     * @inheritDoc
     */
    public function setGender($gender): PersonInterface
    {
        return $this->setData(self::GENDER, $gender);
    }

    /**
     * @inheritDoc
     */
    public function setContent($content): PersonInterface
    {
        return $this->setData(self::CONTENT, $content);
    }
}
