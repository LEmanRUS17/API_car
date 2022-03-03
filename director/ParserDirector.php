<?php

namespace app\director;

use app\builders\ParserBilder;

class ParserDirector
{
    private $builder;

    public function __construct($data)
    {
        $this->builder = new ParserBilder($data);
    }

    public function getCarDromRu()
    {
        $this->builder->setCarTitle();
        $this->builder->setCarDecoration();
        $this->builder->setCarPrice();
        $this->builder->setCarLocality();
        $this->builder->setCarBrand();
        $this->builder->setCarModel();
        $this->builder->setCarBody();
        $this->builder->setCarMileage();
        $this->builder->setCarYear();
        $this->builder->setCarPhoto();

        return $this->builder->getCar();
    }
}