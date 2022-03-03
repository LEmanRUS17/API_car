<?php
namespace dataMapper;

use app\dataMapper\RegionMapper;
use app\entities\EntityRegion;
use app\tests\fixtures\CountryFixture;
use app\tests\fixtures\LocalityFixture;
use app\tests\fixtures\RegionFixture;
use Yii;

class RegionMapperTest extends \Codeception\Test\Unit
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
        $this->stack = require(__DIR__ . '/../../fixtures/data/region.php');
        $this->tester->haveFixtures([
            'Region' => RegionFixture::class,
            'Country' => CountryFixture::class
        ]);
        $this->entity = new EntityRegion([]);
        $this->mapper = new RegionMapper($this->entity);
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
            $this->assertEquals($num['country_id'], $this->entity->getCountryId());
            $this->assertEquals($num['title'], $this->entity->getTitle());
        }
    }

    public function testGet()
    {
        foreach ($this->stack as $num)
        {
            $this->entity->init(['id' => $num['id']]);
            $this->mapper->get();
            $this->assertNotNull($this->entity->getTitle());
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
}