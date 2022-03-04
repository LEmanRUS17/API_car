<?php

namespace app\tests\fixtures;

use yii\test\ActiveFixture;
use yii\test\Fixture;

class CarFixture extends ActiveFixture
{
    public $tableName = 'car';
    public $dataFile = __DIR__ . '/data/car.php';
}