<?php
namespace entities;

use app\entities\EntityLocality;

class LocalityEntityTest extends \Codeception\Test\Unit
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
            'region_id' => 2,
            'title' => 'great locality'
        ];
    }

    // Сравнение входящих и исходящих данных
    public function testContent()
    {
        $fixtures = $this->fixtures();
        $entity = new EntityLocality($fixtures);

        $this->assertEquals($fixtures['id'], $entity->getId(), 'Not received expected id');
        $this->assertEquals($fixtures['region_id'], $entity->getRegionId(), 'Not received expected region id');
        $this->assertEquals($fixtures['title'], $entity->getTitle(), 'Not received expected title');
    }
}