<?php

namespace app\tests\fixtures;

use yii\test\ActiveFixture;
use yii\test\Fixture;

class RegionFixture extends ActiveFixture
{
    public $tableName = 'region';
    public $dataFile = __DIR__ . '/data/region.php';
}