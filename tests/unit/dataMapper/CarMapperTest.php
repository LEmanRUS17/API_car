<?php
namespace dataMapper;

use app\dataMapper\CarMapper;
use app\entities\EntityCar;
use app\entities\EntityUser;
use app\tests\fixtures\CarFixture;
use app\tests\fixtures\CarOptionFixture;
use app\tests\fixtures\CountryFixture;
use app\tests\fixtures\LocalityFixture;
use app\tests\fixtures\OptionFixture;
use app\tests\fixtures\RegionFixture;
use app\tests\fixtures\UserFixture;
use Faker\Factory;
use app\tests\fixtures\UserCarFixture;
use Yii;
use yii\data\SqlDataProvider;

class CarMapperTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    private $stack;
    private $entity;

    public function  _before()
    {
        $this->stack = require(__DIR__ . '/../../fixtures/data/car.php');

        $this->tester->haveFixtures([
            'Car' => CarFixture::class,
            'Option' => OptionFixture::class,
            'CarOption' => CarOptionFixture::class,
            'Locality' => LocalityFixture::class,
            'Region' => RegionFixture::class,
            'Country' => CountryFixture::class,
            'User' => UserFixture::class,
            'UserCar' => UserCarFixture::class
        ]);

        $this->entity = new EntityCar([]);
        $this->mapper = new CarMapper($this->entity);
    }

    // tests
    public function testDelete()
    {
        foreach ($this->stack as $num)
        {
            $this->entity->init(['id' => $num['id']]);
            $this->mapper->delete();
        }
    }

    public function testUpdate()
    {
        foreach ($this->stack as $num)
        {
            $this->entity->init($num);
            $this->mapper->updateCar();
        }
    }

    public function testList()
    {
        $list = $this->mapper->list();

        $this->assertInstanceOf(SqlDataProvider::class, $list, 'Expected class "SqlDataProvider" not received ');
    }

}