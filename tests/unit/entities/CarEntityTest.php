<?php
namespace entities;

use app\entities\EntityCar;
use app\entities\EntityCountry;
use app\entities\EntityLocality;
use app\entities\EntityOption;
use app\entities\EntityRegion;
use app\entities\EntitySpecification;
use app\entities\EntityUser;

class CarEntityTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    
    protected function _before()
    {
    }

    protected function _after()
    {
    }

    public function fixturesGet()
    {
        return [
            'id' => 1,
            'title' => 'title-car',
            'decoration' => 'decoration-car',
            'price' => 100000,
            'photos' => [
                'path1',
                'path2'
            ],
            'user' => new EntityUser(),
            'locality' => [
                new EntityLocality(),
                new EntityRegion(),
                new EntityCountry()
            ],
            'specification' => new EntitySpecification(),
            'options' => [
                new EntityOption(),
                new EntityOption(),
            ]
        ];
    }

    // Сравнение входящих и исходящих данных
    public function testContent()
    {
        $fixtures = $this->fixturesGet();
        $entity = new EntityCar($fixtures);


        $this->assertEquals($fixtures['id'], $entity->getId(), 'Not received expected id');
        $this->assertEquals($fixtures['title'], $entity->getTitle(), 'Not received expected title');
        $this->assertEquals($fixtures['decoration'], $entity->getDecoration(), 'Not received expected decoration');
        $this->assertEquals($fixtures['price'], $entity->getPrice(), 'Not received expected price');
        $this->assertNotEmpty($entity->getPhotos(), 'Photos not received ');
        $this->assertContainsOnlyInstancesOf(EntityUser::class, [$entity->getUser()], 'Not received expected user');

        $this->assertContainsOnlyInstancesOf(EntitySpecification::class, [$entity->getSpecification()], 'Not received expected specification');
        $this->assertContainsOnlyInstancesOf(EntityOption::class, $entity->getOptions(), 'Array contains invalid values');
    }

//    private int $id;
//    private string|null $title = null;
//    private string|null $decoration = null;
//    private int|null $price = null;
//    private array|UploadedFile|null $photos = [];
//    private int|EntityUser|null $user = null;
//    private array|int|null $locality = null;
//    public EntitySpecification|null $specification = null;
//    public EntityOption|array|null $options = [];
}