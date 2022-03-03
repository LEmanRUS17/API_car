<?php

namespace app\tests\fixtures;

use yii\test\ActiveFixture;
use yii\test\Fixture;

class CountryFixture extends ActiveFixture
{
    public $tableName = 'country';
    public $dataFile = __DIR__ . '/data/country.php';
}