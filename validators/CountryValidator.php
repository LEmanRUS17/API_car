<?php

namespace app\validators;

use app\entities\EntityCountry;
use app\services\CountryService;
use yii\validators\NumberValidator;
use yii\validators\StringValidator;

class CountryValidator extends Validator
{
    private $entity;
    private $options;
    private $service;

    private $validatorStr;
    private $validatorId;

    /**
     * @param EntityCountry $entity an object that holds data about a country
     * @param array $options names of fields for validation
     */
    public function __construct(EntityCountry $entity, array $options)
    {
        $this->entity = $entity;
        $this->options = $options;
        $this->service = new CountryService(new EntityCountry());

        $this->validatorStr = new StringValidator(['min' => 3, 'max' => 255]);
        $this->validatorId = new NumberValidator(['min' => 1, 'max' => 100000000]);
    }

    /**
     * Object validation EntityCountry
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
        if (!$this->validatorId->validate($this->entity->getId()))
            $this->addError('id должен быть от 1 до 100000000');

        if (!empty($this->entity->getId())) {
            $id = false;
            foreach ($this->service->list() as $num)
                if ($num['id'] == $this->entity->getId())
                    $id = true;

            if (!$id) $this->addError('Опция не найдена');
        }
    }

    /**
     * Field validation title
     */
    private function title()
    {
        if (empty($this->entity->getTitle()))
            $this->addError('Поле title должно быть заполнено');
        elseif (!$this->validatorStr->validate($this->entity->getTitle()))
            $this->addError('Размер названия страны должен быть от 3 до 255');
    }
}