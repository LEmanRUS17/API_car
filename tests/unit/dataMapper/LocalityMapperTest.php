<?php
namespace dataMapper;


use app\dataMapper\CountryMapper;
use app\dataMapper\LocalityMapper;
use app\entities\EntityLocality;
use app\tests\fixtures\CountryFixture;
use app\tests\fixtures\LocalityFixture;
use app\tests\fixtures\RegionFixture;
use Yii;

class LocalityMapperTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    private $stack;
    private $entity;
    private $mapper;

    protected function _before()
    {
        $this->stack = require(__DIR__ . '/../../fixtures/data/locality.php');
        $this->tester->haveFixtures([
            'locality' => LocalityFixture::class,
            'Region' => RegionFixture::class
        ]);

        $this->entity = new EntityLocality([]);
        $this->mapper = new LocalityMapper($this->entity);
    }

    public function testCreate()
    {
        foreach ($this->stack as $key => $num) {
            $this->entity->init($num);
            $this->mapper->create();

            $this->entity->init(['id' => Yii::$app->db->getLastInsertID()]);
            $this->mapper->get();
            $this->assertEquals($num['region_id'], $this->entity->getRegionId());
            $this->assertEquals($num['title'], $this->entity->getTitle());
        }
    }

    public function testGet()
    {
        foreach ($this->stack as $num) {
            $this->entity->init(['id' => $num['id']]);
            $this->mapper->get();
            $this->assertNotNull($this->entity->getTitle());
            $this->assertNotNull($this->entity->getRegionId());
        }
    }

    public function testList()
    {
        $this->assertIsArray($this->mapper->list());
    }

    public function testDelete()
    {
        foreach ($this->stack as $num) {
            $this->entity->init(['id' => $num['id']]);
            $this->mapper->delete();
        }
    }
}