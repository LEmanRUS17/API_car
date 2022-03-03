<?php

namespace app\validators;

use app\entities\EntityOption;
use yii\validators\StringValidator;

class OptionValidator extends Validator
{
    // массив значений
    private $entity;

    public function __construct(EntityOption $entity)
    {
        $this->entity = $entity;
    }

    function validate()
    {
        $ent = $this->entity;

        $validatorStr = new StringValidator(['min' => 3, 'max' => 255]);

        if (empty($ent->getTitle()))
            $this->addError('Поле title должно быть заполнено');
        elseif (!$validatorStr->validate($ent->getTitle()))
            $this->addError('Размер названия должен быть от 3 до 255');

        return $this->getErrors();
    }
}