<?php

namespace app\interface;

interface InterfaceSearchBuilder
{
    public function setTitle(string $str);

    public function setDecoration(string $str);

    public function setPrice(int $min, int $max);

    public function setBrand(string $str);

    public function setModel(string $str);

    public function setYear(int $min, int $max);

    public function setBody(string $str);

    public function setMileage(int $min, int $max);

    public function setOption(int $num);

    public function getResult();
}