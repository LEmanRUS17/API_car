<?php

namespace app\validators;

use app\entities\EntityCountry;
use app\entities\EntityLocality;
use app\entities\EntityRegion;
use app\services\LocalityService;
use app\services\RegionService;
use yii\validators\NumberValidator;
use yii\validators\StringValidator;

class LocalityValidator extends Validator
{
    // массив значений
    private $entity;
    private $serviceLocality;
    private $serviceRegion;

    private $validatorStr;
    private $validatorId;

    private $options;

    /**
     * @param EntityLocality $entity an object that holds data about a locality
     * @param array $options names of fields for validation
     */
    public function __construct(EntityLocality $entity, array $options)
    {
        $this->entity = $entity;
        $this->options = $options;

        $this->serviceLocality = new LocalityService(new EntityLocality());
        $this->serviceRegion = new RegionService(new EntityRegion());

        $this->validatorStr = new StringValidator(['min' => 3, 'max' => 255]);
        $this->validatorId = new NumberValidator(['min' => 1]);
    }

    /**
     * Object validation EntityLocality
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

        $arr = $this->serviceLocality->list();
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
     * Field validation regionId
     */
    private function regionId()
    {
        if (empty($this->entity->getRegionId()))
            $this->addError('Поле region_id должно быть заполнено');
        elseif (!$this->validatorId->validate($this->entity->getRegionId()))
            $this->addError('ID региона должен быть больше чем 1');

        $arr = $this->serviceRegion->list();
        $reg = false;

        foreach ($arr as $num)
            if ($num['id'] == $this->entity->getRegionId())
                $reg = true;
        if (!$reg)
            $this->addError('ID региона не существует');
    }
}