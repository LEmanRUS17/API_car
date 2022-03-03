<?php
namespace entities;

use app\entities\EntityRegion;

class RegionEntityTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    
    protected function _before()
    {
    }

    public function fixtures()
    {
        return [
            'id' => 1,
            'country_id' => 2,
            'title' => 'great country'
        ];
    }

    // Сравнение входящих и исходящих данных
    public function testContent()
    {
        $fixtures = $this->fixtures();
        $entity = new EntityRegion($fixtures);

        $this->assertEquals($fixtures['id'], $entity->getId(), 'Not received expected id');
        $this->assertEquals($fixtures['country_id'], $entity->getCountryId(), 'Not received expected country id');
        $this->assertEquals($fixtures['title'], $entity->getTitle(), 'Not received expected title');
    }
}