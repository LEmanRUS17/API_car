<?php

namespace app\validators;

use app\entities\EntityCountry;
use app\entities\EntityRegion;
use app\services\CountryService;
use yii\validators\NumberValidator;
use yii\validators\StringValidator;

class RegionValidator extends Validator
{
    private $entity;
    private $country;

    public function __construct(EntityRegion $entity)
    {
        $this->entity = $entity;
        $this->country = new CountryService(new EntityCountry());
    }

    function validate()
    {
        $ent = $this->entity;

        $validatorStr = new StringValidator(['min' => 3, 'max' => 255]);
        $validatorInt = new NumberValidator(['min' => 1]);

        if (empty($ent->getCountryId()))
            $this->addError('Поле country_id должно быть заполнено');
        elseif (!$validatorInt->validate($ent->getCountryId()))
            $this->addError('ID страны должен быть больше чем 1');

        $arr = $this->country->list();
        $reg = false;

        foreach ($arr as $num)
            if ($num['id'] == $ent->getCountryId())
                $reg = true;
        if ($reg == false)
            $this->addError('ID страны не существует');

        if (empty($ent->getTitle()))
            $this->addError('Поле title должно быть заполнено');
        elseif (!$validatorStr->validate($ent->getTitle()))
            $this->addError('Размер названия региона должен быть от 3 до 255');

        return $this->getErrors();
    }
}