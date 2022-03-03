<?php

namespace unit\dataMapper;

use app\dataMapper\CountryMapper;
use app\entities\EntityCountry;
use app\tests\fixtures\CountryFixture;
use app\tests\fixtures\LocalityFixture;
use app\tests\fixtures\RegionFixture;
use Yii;

class CountryMapperTest extends \Codeception\Test\Unit
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
        $this->stack = require(__DIR__ . '/../../fixtures/data/country.php');
        $this->tester->haveFixtures(['Country' => CountryFixture::class]);

        $this->entity = new EntityCountry([]);
        $this->mapper = new CountryMapper($this->entity);
    }

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

    public function testDelete()
    {
        foreach ($this->stack as $num) {
            $this->entity->init(['id' => $num['id']]);
            $this->mapper->delete();
        }

    }

    public function testList()
    {
        $this->assertIsArray($this->mapper->list());
    }
}