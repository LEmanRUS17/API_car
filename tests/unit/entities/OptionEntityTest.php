<?php
namespace entities;

use app\entities\EntityOption;

class OptionEntityTest extends \Codeception\Test\Unit
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
            'title' => 'climate control'
        ];
    }

    // Сравнение входящих и исходящих данных
    public function testContent()
    {
        $fixtures = $this->fixtures();
        $entity = new EntityOption($fixtures);

        $this->assertEquals($fixtures['id'], $entity->getId(), 'Not received expected id');
        $this->assertEquals($fixtures['title'], $entity->getTitle(), 'Not received expected title');
    }
}