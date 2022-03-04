<?php

namespace app\tests\fixtures;

use yii\test\ActiveFixture;

class PhotoFixture extends ActiveFixture
{
    public $tableName = 'image';
    public $dataFile = __DIR__ . '/data/image.php';
}