<?php

namespace app\interface;

interface ParserInterfase
{
    public function setCarTitle();

    public function setCarDecoration();

    public function setCarPrice();

    public function setCarLocality();

    public function setCarBrand();

    public function setCarModel();

    public function setCarBody();

    public function setCarMileage();

    public function setCarYear();

    public function setCarPhoto();

    public function getCar();
}