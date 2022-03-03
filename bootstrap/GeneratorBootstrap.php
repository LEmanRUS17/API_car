<?php

namespace app\bootstrap;

use app\interface\ServicesInterface;
use app\services\CarService;

class GeneratorBootstrap
{
    public function bootstrap($app)
    {
        $container = \Yii::$container;
        $container->set(ServicesInterface::class, CarService::class);
    }
}