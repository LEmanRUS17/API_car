<?php
namespace entities;

use app\entities\EntityCountry;

class CountryEntityTest extends \Codeception\Test\Unit
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
            'title' => 'great country'
        ];
    }

    // Сравнение входящих и исходящих данных
    public function testContent()
    {
        $fixtures = $this->fixtures();
        $entity = new EntityCountry($fixtures);

        $this->assertEquals($fixtures['id'], $entity->getId(), 'Not received expected id');
        $this->assertEquals($fixtures['title'], $entity->getTitle(), 'Not received expected title');
    }
}