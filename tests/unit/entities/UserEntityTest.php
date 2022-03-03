<?php
namespace entities;

use app\entities\EntityCar;
use app\entities\EntityUser;
use Yii;

class UserEntityTest extends \Codeception\Test\Unit
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
            'lastname' => 'testLast',
            'firstname' => 'testFirst',
            'surname' => 'testSur',
            'telephone' => '+7 (963) 00 00000',
            'mail' => 'test@mail.ru',
            'cars' => [
                new EntityCar([])
            ]
        ];
    }

    // Сравнение входящих и исходящих данных
    public function testContent()
    {
        $fixtures = $this->fixtures();
        $entity = new EntityUser($fixtures);

        $this->assertEquals($fixtures['id'], $entity->getId(), 'Not received expected id');
        $this->assertEquals($fixtures['lastname'], $entity->getLastname(), 'Not received expected lastname');
        $this->assertEquals($fixtures['firstname'], $entity->getFirstname(), 'Not received expected firstname');
        $this->assertEquals($fixtures['surname'], $entity->getSurname(), 'Not received expected surname');
        $this->assertEquals($fixtures['telephone'], $entity->getTelephone(), 'Not received expected telephone');
        $this->assertEquals($fixtures['mail'], $entity->getMail(), 'Not received expected mail');
        $this->assertContainsOnlyInstancesOf(EntityCar::class, $entity->getCars(), 'Not received expected car');

    }
}