<?php

namespace app\director;

use app\builders\SearchBuilder;
use Yii;

class SearchDirector
{
    private $builder;

    public function __construct()
    {
        $this->builder = new SearchBuilder();
    }

    public function constructSearch($entity)
    {
        $builder = $this->builder;

        if (!empty($entity->getTitle()))
            $builder->setTitle($entity->getTitle());

        if (!empty($entity->getDecoration()))
            $builder->setDecoration($entity->getDecoration());

        if (!empty($entity->getMinPrice() or !empty($entity->getMaxPrice())))
        {
            $min = Yii::$app->params['min_price'];
            $max = Yii::$app->params['max_price'];

            if (!empty($entity->getMinPrice()))
                $min = $entity->getMinPrice();

            if (!empty($entity->getMaxPrice()))
                $max = $entity->getMaxPrice();

            $builder->setPrice($min, $max);
        }

        $locality = $entity->getLocality();
        if(is_array($locality)) {
            if (!empty($locality['locality']->getId()))
                $builder->setLocality($locality['locality']->getId());

            if (!empty($locality['region']->getId()))
                $builder->setRegion($locality['region']->getId());

            if (!empty($locality['country']->getId()))
                $builder->setCountry($locality['country']->getId());
        }

        if (!empty($entity->getSpecification())) {
            if (!empty(($entity->getSpecification()->getBrand())))
                $builder->setBrand($entity->getSpecification()->getBrand());

            if (!empty($entity->getSpecification()->getModel()))
                $builder->setModel($entity->getSpecification()->getModel());

            if (!empty($entity->getSpecification()->getMinYear()) or !empty($entity->getSpecification()->getMaxYear())) {
                $min = Yii::$app->params['min_year'];
                $max = Yii::$app->params['max_year'];

                if (!empty($entity->getSpecification()->getMinYear()))
                    $min = $entity->getSpecification()->getMinYear();

                if (!empty($entity->getSpecification()->getMaxYear()))
                    $max = $entity->getSpecification()->getMaxYear();

                $builder->setYear($min, $max);
            }

            if (!empty($entity->getSpecification()->getBody()))
                $builder->setBody($entity->getSpecification()->getBody());

            if (!empty($entity->getSpecification()->getMinMileage()) or !empty($entity->getSpecification()->getMaxMileage())) {
                $min = Yii::$app->params['min_mileage'];
                $max = Yii::$app->params['max_mileage'];

                if (!empty($entity->getSpecification()->getMinMileage()))
                    $min = $entity->getSpecification()->getMinMileage();

                if (!empty($entity->getSpecification()->getMaxMileage()))
                    $max = $entity->getSpecification()->getMaxMileage();

                $builder->setMileage($min, $max);
            }
        }

        if (!empty($entity->getOptions())) {
            $arr = $entity->getOptions();
            foreach ($arr as $num) {
                if (!empty($num->getId()))
                    $builder->setOption($num->getId());
            }
        }

        return $this->builder->getResult();
    }
}