<?php

namespace app\interface;

interface CarMapperInterface
{
    public function get();

    public function createCar();

    public function updateCar();

    public function search();
}