<?php
namespace entities;

use app\entities\EntityPhoto;
use yii\web\UploadedFile;

class PhotoEntityTest extends \Codeception\Test\Unit
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

    public function fixturesSet()
    {
        return [
            'id' => 1,
            'photo' => new UploadedFile(),
            'car_id' => 1
        ];
    }

    public function fixtureGet()
    {
        return [
            'id' => 1,
            'photo' => 'path',
            'car_id' => 1
        ];
    }

    // Сравнение входящих и исходящих данных
    public function testContentSet()
    {
        $fixtures = $this->fixturesSet();
        $entity = new EntityPhoto($fixtures);

        $this->assertEquals($fixtures['id'], $entity->getId(), 'Not received expected id');
        $this->assertContainsOnlyInstancesOf(UploadedFile::class, [$entity->getPhoto()], 'Not received expected photo');
        $this->assertEquals($fixtures['car_id'], $entity->getCarId(), 'Not received expected car id');

    }

    // Сравнение входящих и исходящих данных
    public function testContentGet()
    {
        $fixtures = $this->fixturesSet();
        $entity = new EntityPhoto($fixtures);

        $this->assertEquals($fixtures['id'], $entity->getId(), 'Not received expected id');
        $this->assertEquals($fixtures['photo'], $entity->getPhoto(), 'Not received expected photo');
        $this->assertEquals($fixtures['car_id'], $entity->getCarId(), 'Not received expected car id');
    }
}