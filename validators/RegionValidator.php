<?php

namespace app\validators;

use app\entities\EntityCountry;
use app\entities\EntityRegion;
use app\services\CountryService;
use app\services\RegionService;
use yii\validators\NumberValidator;
use yii\validators\StringValidator;

class RegionValidator extends Validator
{
    // массив значений
    private $entity;
    private $serviceRegion;

    private $validatorStr;
    private $validatorId;

    private $options;

    /**
     * @param EntityRegion $entity an object that holds data about a region
     * @param array $options names of fields for validation
     */
    public function __construct(EntityRegion $entity, array $options)
    {
        $this->entity = $entity;
        $this->options = $options;

        $this->serviceCountry = new CountryService(new EntityCountry());
        $this->serviceRegion = new RegionService(new EntityRegion());

        $this->validatorStr = new StringValidator(['min' => 3, 'max' => 255]);
        $this->validatorId = new NumberValidator(['min' => 1]);
    }

    /**
     * Object validation EntityRegion
     * @return bool|void Error message with code MISDIRECTED_REQUEST:421 or True
     */
    function validate()
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
            $this->addError('ID должен быть больше чем 1');

        $arr = $this->serviceRegion->list();
        $loc = false;

        foreach ($arr as $num)
            if ($num['id'] == $this->entity->getId())
                $loc = true;
        if (!$loc)
            $this->addError('ID региона не существует');
    }

    /**
     * Field validation title
     */
    private function title()
    {
        if (empty($this->entity->getTitle()))
            $this->addError('Поле title должно быть заполнено');
        elseif (!$this->validatorStr->validate($this->entity->getTitle()))
            $this->addError('Размер названия местоположения должен быть от 3 до 255');
    }

    /**
     * Field validation title
     */
    private function countryId()
    {
        if (empty($this->entity->getCountryId()))
            $this->addError('Поле country_id должно быть заполнено');
        elseif (!$this->validatorId->validate($this->entity->getCountryId()))
            $this->addError('ID страны должен быть больше чем 1');

        $arr = $this->serviceCountry->list();
        $con = false;

        foreach ($arr as $num)
            if ($num['id'] == $this->entity->getCountryId())
                $con = true;
        if (!$con)
            $this->addError('ID страны не существует');
    }
}