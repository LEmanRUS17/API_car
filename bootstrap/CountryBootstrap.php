<?php

namespace app\bootstrap;

use yii\base\BootstrapInterface;

class CountryBootstrap implements BootstrapInterface
{
    public function bootstrap($app)
    {
        $container = \Yii::$container;

        $container->set(StorageInterface::class, CountryStorage::class);
        $container->set(ServicesInterface::class, CountryService::class);
        $container->set(MapperInterface::class, CountryMapper::class);
    }
}