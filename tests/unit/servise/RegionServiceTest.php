<?php
namespace servise;

use app\entities\EntityRegion;
use app\services\RegionService;
use app\tests\fixtures\CountryFixture;
use app\tests\fixtures\RegionFixture;
use Yii;

class RegionServiceTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    private $stack;
    private $service;

    protected function _before()
    {
        $this->stack = require(__DIR__ . '/../../fixtures/data/region.php');
        $this->tester->haveFixtures([
            'Region' => RegionFixture::class,
            'Country' => CountryFixture::class
        ]);

        $this->service = new RegionService(new EntityRegion([]));
    }

    // tests
    public function testCreate()
    {
        foreach ($this->stack as $num)
        {
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
        foreach ($this->stack as $num) {
            $answer = $this->service->delete($num['id']);

            $this->assertIsArray($answer);
            $this->assertArrayHasKey('success', $answer);

        }

    }
}