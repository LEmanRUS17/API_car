<?php

namespace app\validators;

use app\entities\EntityUser;
use app\services\UserService;
use yii\validators\EmailValidator;
use yii\validators\NumberValidator;
use yii\validators\StringValidator;

class GetUserValidate extends Validator
{
    // массив значений
    private $entity;
    private $users;

    public function __construct(EntityUser $entity)
    {
        $this->entity = $entity;
        $this->users = new UserService(new EntityUser());
    }

    public function validate()
    {
        $ent = $this->entity;

        $validationId = new NumberValidator(['min' => 1, 'max' => 100000000]);

        if (empty($ent->getId()))
            $this->addError('Поле id должно быть заполнено');
        elseif (!$validationId->validate($ent->getId()))
            $this->addError('Размер id должен быть от 1 до 100000000');

        $arr = $this->users->listUser();
        $u = false;
        foreach ($arr as $num)
            if ($num['id'] == $ent->getId())
                $u = true;
        if ($u == false)
            $this->addError('Пользователь не найден');

        return $this->getErrors();
    }
}