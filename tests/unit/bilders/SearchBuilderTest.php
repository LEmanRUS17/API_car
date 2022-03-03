<?php
namespace dataMapper;

use app\builders\SearchBuilder;
use app\builders\SearchDirector;
use app\entities\EntityCar;
use Yii;

class SearchBuilderTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    private $bilder;

    public function  _before()
    {
        $this->stack = require(__DIR__ . '/../../fixtures/data/car.php');

        $this->bilder = new SearchBuilder();
        $this->db = Yii::$app->db; // Подключение Базы данных
    }

    public function testGetResult()
    {
        $str = $this->bilder->getResult();
        $this->tester->assertIsString($str);

        $arr = $this->db->createCommand($str)->queryAll();

        $this->assertIsArray($arr);
    }
}