<?php
namespace entities;

use app\entities\EntitySpecification;

class SpecificationEntityTest extends \Codeception\Test\Unit
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

    public function fixtures()
    {
        return [
            'id' => 1,
            'car_id' => 1,
            'brand' => 'brand-BMV',
            'model' => 'model-sedan',
            'year_of_issue' => 2000,
            'body' => 'body-big',
            'mileage' => 777777,

            // search
            'min_year' => 1990,
            'max_year' => 2010,
            'min_mileage' => 111111,
            'max_mileage' => 999999,
        ];
    }

    // Сравнение входящих и исходящих данных
    public function testContent()
    {
        $fixtures = $this->fixtures();
        $entity = new EntitySpecification($fixtures);

        $this->assertEquals($fixtures['id'], $entity->getId(), 'Not received expected id');
        $this->assertEquals($fixtures['car_id'], $entity->getCarId(), 'Not received expected car id');
        $this->assertEquals($fixtures['brand'], $entity->getBrand(), 'Not received expected brand');
        $this->assertEquals($fixtures['model'], $entity->getModel(), 'Not received expected model');
        $this->assertEquals($fixtures['year_of_issue'], $entity->getYearOfIssue(), 'Not received expected year of issue');
        $this->assertEquals($fixtures['body'], $entity->getBody(), 'Not received expected body');
        $this->assertEquals($fixtures['mileage'], $entity->getMileage(), 'Not received expected mileage');
        $this->assertEquals($fixtures['min_year'], $entity->getMinYear(), 'Not received expected min year');
        $this->assertEquals($fixtures['max_year'], $entity->getMaxYear(), 'Not received expected max year');
        $this->assertEquals($fixtures['min_mileage'], $entity->getMinMileage(), 'Not received expected min mileage');
        $this->assertEquals($fixtures['max_mileage'], $entity->getMaxMileage(), 'Not received expected max mileage');
    }
}