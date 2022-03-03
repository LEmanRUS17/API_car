<?php

namespace app\validators;

use app\entities\EntityCountry;
use app\entities\EntityLocality;
use app\entities\EntityRegion;
use app\services\RegionService;
use yii\validators\NumberValidator;
use yii\validators\StringValidator;

class LocalityValidator extends Validator
{
    private $entity;
    private $region;

    public function __construct(EntityLocality $entity)
    {
        $this->entity = $entity;
        $this->region = new RegionService(new EntityRegion());
    }

    function validate()
    {
        $ent = $this->entity;

        $validatorStr = new StringValidator(['min' => 3, 'max' => 255]);
        $validatorInt = new NumberValidator(['min' => 1]);

        if (empty($ent->getRegionId()))
            $this->addError('Поле region_id должно быть заполнено');
        elseif (!$validatorInt->validate($ent->getRegionId()))
            $this->addError('ID региона должен быть больше чем 1');

        $arr = $this->region->list();
        $reg = false;

        foreach ($arr as $num)
            if ($num['id'] == $ent->getRegionId())
                $reg = true;
            if ($reg == false)
                $this->addError('ID региона не существует');

        if (empty($ent->getTitle()))
            $this->addError('Поле title должно быть заполнено');
        elseif (!$validatorStr->validate($ent->getTitle()))
            $this->addError('Размер названия местоположения должен быть от 3 до 255');

        return $this->getErrors();
    }
}