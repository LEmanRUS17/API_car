<?php
namespace servise;

use app\entities\EntityCountry;
use app\services\CountryService;
use app\tests\fixtures\CountryFixture;
use Yii;

class CountryServiceTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    private $stack;
    private $service;

    protected function _before()
    {
        $this->stack = require(__DIR__ . '/../../fixtures/data/country.php');
        $this->tester->haveFixtures(['Country' => CountryFixture::class]);

        $this->service = new CountryService(new EntityCountry([]));
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
        foreach ($this->stack as $num)
        {
            $answer = $this->service->delete($num['id']);

            $this->assertIsArray($answer);
            $this->assertArrayHasKey('success', $answer);
        }
    }
}