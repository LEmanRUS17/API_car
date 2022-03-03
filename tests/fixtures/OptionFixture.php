<?php

namespace app\tests\fixtures;

use yii\test\ActiveFixture;
use yii\test\Fixture;

class OptionFixture extends ActiveFixture
{
    public $tableName = 'option';
    public $dataFile = __DIR__ . '/data/option.php';
}