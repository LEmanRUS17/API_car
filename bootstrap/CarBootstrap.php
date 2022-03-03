<?php

namespace app\bootstrap;

use app\DataMapper\CarMapper;
use app\interface\MapperInterface;
use app\services\CarService;
use app\interface\ServicesInterface;
use app\storage\CarStorage;
use app\interface\CarStorageInterface;
use app\interface\StorageInterface;
use app\interface\CarServicesInterface;
use yii;
use yii\base\BootstrapInterface;
use yii\di\Container;

class CarBootstrap implements BootstrapInterface
{

    public function bootstrap($app)
    {
        $container = \Yii::$container;

//        $container->setSingleton( CarService::class);
        $container->set(StorageInterface::class, CarStorage::class);
        $container->set(CarStorageInterface::class, CarStorage::class);
        $container->set(ServicesInterface::class, CarService::class);
        $container->set(CarServicesInterface::class, CarService::class);
        $container->set(MapperInterface::class, CarMapper::class);
    }
}