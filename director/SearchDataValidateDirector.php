<?php

namespace app\director;

use app\builders\ValidatorBuilder;
use app\entities\EntityCar;
use app\validators\Validator;
use Yii;

class SearchDataValidateDirector extends Validator
{
    private $builder;
    private $entity;

    public function __construct(EntityCar $entity)
    {
        $this->entity = $entity;
        $this->builder = new ValidatorBuilder();
    }

    function validate()
    {
        if (!empty($this->entity->getTitle()))
            $this->builder->validateTitle($this->entity->getTitle());
        if (!empty($this->entity->getDecoration()))
            $this->builder->validateDecoration($this->entity->getDecoration());


        // price:
        if (!empty($this->entity->getMinPrice()))
            $min = $this->entity->getMinPrice();
        else
            $min = Yii::$app->params['min_price'];

        if (!empty($this->entity->getMaxPrice()))
            $max = $this->entity->getMaxPrice();
        else
            $max = Yii::$app->params['max_price'];

        $this->builder->validateMinMaxPrice($min, $max);
        // ---

        $specification = $this->entity->getSpecification();

        if (!empty($specification->getBrand()))
            $this->builder->validateBrand($specification->getBrand());
        if (!empty($specification->getModel()))
            $this->builder->validateModel($specification->getModel());

        // year_of_issue:
        if (!empty($specification->getMinYear()))
            $min = $specification->getMinYear();
        else
            $min = Yii::$app->params['min_year'];

        if (!empty($specification->getMaxYear()))
            $max = $specification->getMaxYear();
        else
            $max = Yii::$app->params['max_year'];

        $this->builder->validateMinMaxYear($min, $max);
        // ---

        if (!empty($specification->getBody()))
            $this->builder->validateBody($specification->getBody());

        // mileage:
        if (!empty($specification->getMinMileage()))
            $min = $specification->getMinMileage();
        else
            $min = Yii::$app->params['min_mileage'];

        if (!empty($specification->getMaxMileage()))
            $max = $specification->getMaxMileage();
        else
            $max = Yii::$app->params['max_mileage'];

        $this->builder->validateMinMaxMileage($min, $max);
        // ---

        foreach ($this->builder->getErrors() as $error) {
            $this->addError($error);
        }

        return $this->getErrors();
    }
}