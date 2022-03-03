<?php

namespace app\entities;

use yii\data\ArrayDataProvider;

class EntityUser
{
    private int|null $id = null;
    private string|null $lastname = null;
    private string|null $firstname = null;
    private string|null $surname = null;
    private string|null $telephone = null;
    private string|null $mail = null;
    private array|ArrayDataProvider|null $cars = null;

    public function __construct(array $arr = [])
    {
        $this->init($arr);
    }

    public function init(array $arr)
    {
        if (isset($arr))
            foreach ($arr as $key => $num) {
                try {
                    $this->$key = $num;
                } catch (\TypeError) {}
            }
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string|null
     */
    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    /**
     * @param string|null $lastname
     */
    public function setLastname(?string $lastname): void
    {
        $this->lastname = $lastname;
    }

    /**
     * @return string|null
     */
    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    /**
     * @param string|null $firstname
     */
    public function setFirstname(?string $firstname): void
    {
        $this->firstname = $firstname;
    }

    /**
     * @return string|null
     */
    public function getSurname(): ?string
    {
        return $this->surname;
    }

    /**
     * @param string|null $surname
     */
    public function setSurname(?string $surname): void
    {
        $this->surname = $surname;
    }

    /**
     * @return string|null
     */
    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    /**
     * @param string|null $telephone
     */
    public function setTelephone(?string $telephone): void
    {
        $this->telephone = $telephone;
    }

    /**
     * @return string|null
     */
    public function getMail(): ?string
    {
        return $this->mail;
    }

    /**
     * @param string|null $mail
     */
    public function setMail(?string $mail): void
    {
        $this->mail = $mail;
    }

    /**
     * @return array|ArrayDataProvider|null
     */
    public function getCars(): array|ArrayDataProvider|null
    {
        return $this->cars;
    }

    /**
     * @param array|ArrayDataProvider|null $cars
     */
    public function setCars(array|ArrayDataProvider|null $cars): void
    {
        $this->cars = $cars;
    }

    public function getAll()
    {
        $cars = [];
        if (!empty($this->cars)) {
            foreach ($this->cars as $num) {
                $cars[] = $num->getAll();
            }
        }

        return [
            'id'        => $this->id,
            'lastname'  => $this->lastname,
            'firstname' => $this->firstname,
            'surname'   => $this->surname,
            'telephone' => $this->telephone,
            'mail'      => $this->mail,
            'cars'      => $cars
        ];
    }

}