<?php

namespace Elogic\Person\Api\Data;

/**
 * Interface PersonInterface
 */
interface PersonInterface
{
    const ENTITY_ID ='entity_id';
    const NAME ='name';
    const SURNAME ='surname';
    const AGE = 'age';
    const GENDER ='gender';
    const CONTENT = 'content';

    /**
     * @return mixed
     */
    public function getId();

    /**
     * @return mixed
     */
    public function getName();

    /**
     * @return mixed
     */
    public function getSurname();

    /**
     * @return mixed
     */
    public function getAge();

    /**
     * @return mixed
     */
    public function getGender();

    /**
     * @return mixed
     */
    public function getContent();

    /**
     * @param $name
     * @return PersonInterface
     */
    public function setName($name): PersonInterface;

    /**
     * @param $surname
     * @return PersonInterface
     */
    public function setSurname($surname): PersonInterface;

    /**
     * @param $age
     * @return PersonInterface
     */
    public function setAge($age): PersonInterface;

    /**
     * @param  $gender
     * @return PersonInterface
     */
    public function setGender($gender): PersonInterface;

    /**
     * @param  $content
     * @return PersonInterface
     */
    public function setContent($content): PersonInterface;
}
