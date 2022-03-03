<?php
namespace dataMapper;

use app\dataMapper\OptionMapper;
use app\entities\EntityOption;
use app\tests\fixtures\OptionFixture;
use Yii;

class OptionMapperTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    private $entity;
    private $stack;
    private $mapper;

    protected function _before()
    {
        $this->stack = require(__DIR__ . '/../../fixtures/data/option.php');
        $this->tester->haveFixtures(['option' => OptionFixture::class]);

        $this->entity = new EntityOption([]);
        $this->mapper = new OptionMapper($this->entity);
    }

    // tests
    public function testCreate()
    {
        foreach ($this->stack as $num)
        {
            $this->entity->init($num);
            $this->mapper->create();

            $this->entity->init(['id' => Yii::$app->db->getLastInsertID()]);
            $this->mapper->get();
            $this->assertEquals($num['title'], $this->entity->getTitle());
        }
    }

    public function testList()
    {
        $this->assertIsArray($this->mapper->list());
    }

    public function testDelete()
    {
        foreach ($this->stack as $num)
        {
            $this->entity->init(['id' => $num['id']]);
            $this->mapper->delete();
        }
    }

    public function testCountList()
    {
        $this->mapper->countList();
        $list = $this->mapper->list();

        $this->assertIsArray($list);
    }
}