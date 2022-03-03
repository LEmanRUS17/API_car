<?php

namespace app\validators;

use app\entities\EntityUser;
use yii\validators\EmailValidator;
use yii\validators\StringValidator;

class UserValidate extends Validator
{
    // массив значений
    private $entity;

    public function __construct(EntityUser $entity)
    {
        $this->entity = $entity;
    }

    public function validate()
    {
        $ent = $this->entity;

        $validatorStr = new StringValidator(['min' => 3, 'max' => 255]);
        $validatorTelephone = new StringValidator(['min' => 3, 'max' => 20]);

        $fullPattern = '/^[^@]*<[a-zA-Z0-9!#$%&\'*+\/=?^_`{|}~-]+(?:\.[a-zA-Z0-9!#$%&\'*+\/=?^_`{|}~-]+)*@(?:[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?\.)+[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?>$/';
        $validatorMail = new EmailValidator(['allowName' => true, 'fullPattern' => $fullPattern]);

        if (empty($ent->getLastname()))
            $this->addError('Поле lastname должно быть заполнено');
        elseif (!$validatorStr->validate($ent->getLastname()))
            $this->addError('Размер lastname должен быть от 3 до 255');

        if (empty($ent->getFirstname()))
            $this->addError('Поле firstname должно быть заполнено');
        elseif (!$validatorStr->validate($ent->getFirstname()))
            $this->addError('Размер firstname должен быть от 3 до 255');

        if (empty($ent->getSurname()))
            $this->addError('Поле surname должно быть заполнено');
        elseif (!$validatorStr->validate($ent->getSurname()))
            $this->addError('Размер surname должен быть от 3 до 255');

        if (empty($ent->getTelephone()))
            $this->addError('Поле telephone должно быть заполнено');
        elseif (!$validatorTelephone->validate($ent->getTelephone()))
            $this->addError('Размер telephone должен быть от 3 до 20');

//        if (empty($ent->getMail()))
//            $this->addError('Поле mail должно быть заполнено');
//        elseif (!$validatorMail->validate($ent->getTelephone()))
//            $this->addError('mail заполнен не верно');

        return $this->getErrors();
    }

}