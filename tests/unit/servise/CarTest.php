<?php
namespace servise;

use app\entities\EntityCar;
use app\entities\EntityOption;
use app\entities\EntityUser;
use app\services\CarService;
use app\tests\fixtures\CarFixture;
use app\tests\fixtures\CountryFixture;
use app\tests\fixtures\LocalityFixture;
use app\tests\fixtures\OptionFixture;
use app\tests\fixtures\RegionFixture;
use app\tests\fixtures\UserCarFixture;
use app\tests\fixtures\UserFixture;
use Faker\Factory;
use Yii;
use yii\data\SqlDataProvider;
use yii\debug\models\timeline\DataProvider;

class CarTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    private $service;
    private $stack;

    protected function _before()
    {
        $this->stack = require(__DIR__ . '/../../fixtures/data/car.php');
        $this->tester->haveFixtures([
            'car' => CarFixture::class,
            'locality' => LocalityFixture::class,
            'region' => RegionFixture::class,
            'country' => CountryFixture::class,
            'user' => UserFixture::class,
            'option' => OptionFixture::class,
            'user_car' => UserCarFixture::class,
        ]);

        $_FILES['photos'] = [
            'name' => ['test.jpg'],
            'type' => ['image/jpeg'],
            'tmp_name' => ['/var/www/html/projectyii/API_test/web/image/imageTest/test'],
            'error' => [0],
            'size' => [52066]];

        $this->service = new CarService(new EntityCar([]), new EntityOption());
    }

    // tests
    public function testCreate()
    {
        foreach ($this->stack as $key => $num)
        {
            $answer = $this->service->create($num);

            $this->assertIsArray($answer);
            $this->assertArrayHasKey('success', $answer);
        }
    }

    public function testSearch()
    {
        foreach ($this->stack as $key => $num)
        {
            $answer = $this->service->search([$num['title']]);
            $this->assertContainsOnlyInstancesOf(SqlDataProvider::class, [$answer]);
        }
    }

    public function testList()
    {
        $answer = $this->service->list();
        $this->assertContainsOnlyInstancesOf(SqlDataProvider::class, [$answer]);
    }

}