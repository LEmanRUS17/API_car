<?php
namespace dataMapper;

use app\dataMapper\UserMapper;
use app\entities\EntityUser;
use app\tests\fixtures\CarFixture;
use app\tests\fixtures\CountryFixture;
use app\tests\fixtures\LocalityFixture;
use app\tests\fixtures\OptionFixture;
use app\tests\fixtures\RegionFixture;
use app\tests\fixtures\UserCarFixture;
use app\tests\fixtures\UserFixture;
use Yii;

use yii\data\SqlDataProvider;

class UserMapperTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    private $entity;
    private $stack;
    private $mapper;

    public function _before()
    {
        $this->stack = require(__DIR__ . '/../../fixtures/data/user.php');

        $this->tester->haveFixtures([
            'User' => UserFixture::class,
            'UserCar' => UserCarFixture::class,
            'Car' => CarFixture::class,
            'Locality' => LocalityFixture::class,
            'Region' => RegionFixture::class,
            'Country' => CountryFixture::class
        ]);

        $this->entity = new EntityUser([]);
        $this->mapper = new UserMapper($this->entity);
    }

    // tests
    public function testCreate()
    {
        foreach ($this->stack as $key => $num)
        {
            $this->entity->init($num);
            $this->mapper->create();

            $this->entity->init(['id' => Yii::$app->db->getLastInsertID()]);
            $this->mapper->get();
            $this->assertEquals($num['lastname'], $this->entity->getLastname(), 'Not received expected lastname');
            $this->assertEquals($num['firstname'], $this->entity->getFirstname(), 'Not received expected firstname');
            $this->assertEquals($num['surname'], $this->entity->getSurname(), 'Not received expected surname');
            $this->assertEquals($num['telephone'], $this->entity->getTelephone(), 'Not received expected telephone');
            $this->assertEquals($num['mail'], $this->entity->getMail(), 'Not received expected mail');
        }

    }

    public function testGet()
    {
        foreach ($this->stack as $num) {
            $this->entity->init(['id' => $num['id']]);
            $this->mapper->get();
            $this->assertNotNull($this->entity->getLastname());
        }
    }

    public function testDelete()
    {
        foreach ($this->stack as $num) {
            $this->entity->init(['id' => $num['id']]);
            $this->mapper->delete();
        }
    }

//    public function testUpdate()
//    {
//        foreach ($this->stack as $num) {
//            $this->entity->init($num);
//            $this->mapper->update();
//
//            $this->mapper->get();
//
//            $this->assertEquals($num['lastname'], $this->entity->getLastname(), 'Not received expected lastname');
//            $this->assertEquals($num['firstname'], $this->entity->getFirstname(), 'Not received expected firstname');
//            $this->assertEquals($num['surname'], $this->entity->getSurname(), 'Not received expected surname');
//            $this->assertEquals($num['telephone'], $this->entity->getTelephone(), 'Not received expected telephone');
//            $this->assertEquals($num['mail'], $this->entity->getMail(), 'Not received expected mail');
//        }
//
//    }

    public function testList()
    {
        $list = $this->mapper->list();

        $this->assertInstanceOf(SqlDataProvider::class, $list, 'Expected class "SqlDataProvider" not received ');
    }

}