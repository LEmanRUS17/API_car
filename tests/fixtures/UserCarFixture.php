<?php

namespace app\tests\fixtures;

use yii\test\ActiveFixture;
use yii\test\Fixture;

class UserCarFixture extends ActiveFixture
{
    public $tableName = 'user_car';
    public $dataFile = __DIR__ . '/data/user_car.php';
}