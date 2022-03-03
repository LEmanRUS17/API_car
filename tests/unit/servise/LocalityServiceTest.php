<?php
namespace servise;

use app\entities\EntityLocality;
use app\services\LocalityService;
use app\tests\fixtures\CountryFixture;
use app\tests\fixtures\LocalityFixture;
use app\tests\fixtures\RegionFixture;
use Yii;

class LocalityTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    private $stack;
    private $service;

    protected function _before()
    {
        $this->stack = require(__DIR__ . '/../../fixtures/data/locality.php');
        $this->tester->haveFixtures([
            'locality' => LocalityFixture::class,
            'Region' => RegionFixture::class
        ]);

        $this->service = new LocalityService(new EntityLocality([]));
    }

    // tests
    public function testCreate()
    {
        foreach ($this->stack as $key => $num) {
            $answer = $this->service->create($num);

            $this->assertIsArray($answer);
            $this->assertArrayHasKey('success', $answer);

            $answer = $this->service->get(['id' => Yii::$app->db->getLastInsertID()]);
            $this->assertIsArray($answer);

            $this->assertEquals($num['title'], $answer['title']);
        }

    }

    public function testDelete()
    {
        foreach ($this->stack as $key => $num)
        {
            $answer = $this->service->delete($num['id']);

            $this->assertIsArray($answer);
            $this->assertArrayHasKey('success', $answer);
        }
    }
}