<?php

namespace app\bootstrap;

use app\DataMapper\CarMapper;
use app\interface\MapperInterface;
use app\services\CarService;
use app\interface\ServicesInterface;
use app\storage\CarStorage;
use app\interface\StorageInterface;
use yii\base\Application;
use yii\base\BootstrapInterface;

class OptionBootstrap implements BootstrapInterface
{

    public function bootstrap($app)
    {
        $container = \Yii::$container;
        $container->set(StorageInterface::class, CarStorage::class);
        $container->set(ServicesInterface::class, CarService::class);
        $container->set(MapperInterface::class, CarMapper::class);
    }
}