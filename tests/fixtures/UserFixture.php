<?php

namespace app\tests\fixtures;

use yii\test\ActiveFixture;
use yii\test\Fixture;

class UserFixture extends ActiveFixture
{
    public $tableName = 'user';
    public $dataFile = __DIR__ . '/data/user.php';
}