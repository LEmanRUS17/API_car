<?php

namespace app\tests\fixtures;

use yii\test\ActiveFixture;
use yii\test\Fixture;

class CarOptionFixture extends ActiveFixture
{
    public $tableName = 'car_option';
    public $dataFile = __DIR__ . '/data/car_option.php';
}