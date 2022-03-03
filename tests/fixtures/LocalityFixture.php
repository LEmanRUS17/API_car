<?php

namespace app\tests\fixtures;

use yii\test\ActiveFixture;
use yii\test\Fixture;

class LocalityFixture extends ActiveFixture
{
    public $tableName = 'locality';
    public $dataFile = __DIR__ . '/data/locality.php';
}