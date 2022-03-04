<?php

namespace app\validators;

use app\entities\EntityUser;
use app\services\UserService;
use yii\validators\EmailValidator;
use yii\validators\NumberValidator;
use yii\validators\StringValidator;

class UserValidate extends Validator
{
    // массив значений
    private $entity;
    private $users;
    private $options;

    private $validatorId;
    private $validatorStr;
    private $validatorTelephone;
    private $validatorMail;

    /**
     * @param EntityUser $entity an object that holds data about a user
     * @param array $options names of fields for validation
     */
    public function __construct(EntityUser $entity, array $options)
    {
        $this->entity = $entity;
        $this->options = $options;

        $this->validatorId = new NumberValidator(['min' => 1, 'max' => 100000000]);
        $this->validatorStr = new StringValidator(['min' => 3, 'max' => 255]);
        $this->validatorTelephone = new StringValidator(['min' => 3, 'max' => 20]);

        $fullPattern = '/^[^@]*<[a-zA-Z0-9!#$%&\'*+\/=?^_`{|}~-]+(?:\.[a-zA-Z0-9!#$%&\'*+\/=?^_`{|}~-]+)*@(?:[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?\.)+[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?>$/';
        $this->validatorMail = new EmailValidator(['allowName' => true, 'fullPattern' => $fullPattern]);

        $this->users = new UserService(new EntityUser());
    }

    /**
     * Object validation EntityUser
     * @return bool|void Error message with code MISDIRECTED_REQUEST:421 or True
     */
    public function validate()
    {
        foreach ($this->options as $option)
            $this->$option();

        return $this->getErrors();
    }

    /**
     * Field validation id
     */
    private function id()
    {
        if (empty($this->entity->getId()))
            $this->addError('Поле id должно быть заполнено');
        elseif (!$this->validatorId->validate($this->entity->getId()))
            $this->addError('Размер id должен быть от 1 до 100000000');

        $arr = $this->users->listUser();
        $u = false;
        foreach ($arr as $num)
            if ($num['id'] == $this->entity->getId())
                $u = true;
        if ($u == false)
            $this->addError('Пользователь не найден');
    }

    /**
     * Field validation lastname
     */
    private function lastname()
    {
        if (empty($this->entity->getLastname()))
            $this->addError('Поле lastname должно быть заполнено');
        elseif (!$this->validatorStr->validate($this->entity->getLastname()))
            $this->addError('Размер lastname должен быть от 3 до 255');
    }

    /**
     * Field validation firstname
     */
    private function firstname()
    {
        if (empty($this->entity->getFirstname()))
            $this->addError('Поле firstname должно быть заполнено');
        elseif (!$this->validatorStr->validate($this->entity->getFirstname()))
            $this->addError('Размер firstname должен быть от 3 до 255');
    }

    /**
     * Field validation surname
     */
    private function surname()
    {
        if (empty($this->entity->getSurname()))
            $this->addError('Поле surname должно быть заполнено');
        elseif (!$this->validatorStr->validate($this->entity->getSurname()))
            $this->addError('Размер surname должен быть от 3 до 255');
    }

    /**
     * Field validation telephone
     */
    private function telephone()
    {
        if (empty($this->entity->getTelephone()))
            $this->addError('Поле telephone должно быть заполнено');
        elseif (!$this->validatorTelephone->validate($this->entity->getTelephone()))
            $this->addError('Размер telephone должен быть от 3 до 20');
    }

    /**
     * Field validation mail
     */
    private function mail()
    {
        if (empty($this->entity->getMail()))
            $this->addError('Поле mail должно быть заполнено');
        elseif (!$this->validatorMail->validate($this->entity->getTelephone()))
            $this->addError('mail заполнен не верно');
    }
}