<?php
namespace servise;

use app\entities\EntityOption;
use app\services\OptionService;
use app\tests\fixtures\OptionFixture;
use Yii;

class OptionTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    private $stack;
    private $service;
    
    protected function _before()
    {

        $this->stack = require(__DIR__ . '/../../fixtures/data/option.php');
        $this->tester->haveFixtures(['option' => OptionFixture::class]);

        $this->service = new OptionService(new EntityOption([]));
    }

    // tests
    public function testCreate()
    {
        foreach ($this->stack as $num) {

            $answer = $this->service->create($num);

            $this->assertIsArray($answer);
            $this->assertArrayHasKey('success', $answer);

            $answer = $this->service->get(Yii::$app->db->getLastInsertID());
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