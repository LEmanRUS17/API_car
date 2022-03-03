<?php

namespace app\dataMapper;

use app\entities\EntityCar;
use Yii;

class SpecificationMapper
{
    private $entity; // entity
    private $db;        // БД

    public function __construct(EntityCar $entity)
    {
        $this->entity = $entity; // Подключение entity
        $this->db = Yii::$app->db; // Подключение Базы данных
    }

    public function createSpecification(int $id = null) // Добавить спецификации для машины
    {
        if ($id == null )
            $id = $this->entity->getId();

        if (isset($this->entity->specification))
            $this->db->createCommand("INSERT INTO specification (car_id, brand, model, body, mileage, year_of_issue)
            VALUES (:car_id, :brand, :model, :body, :mileage, :year_of_issue)", [
                ':car_id' => $id,
                ':brand' => $this->entity->getSpecification()->getBrand(),
                ':model' => $this->entity->getSpecification()->getModel(),
                ':body' => $this->entity->getSpecification()->getBody(),
                ':mileage' => $this->entity->getSpecification()->getMileage(),
                ':year_of_issue' => $this->entity->getSpecification()->getYearOfIssue()
            ])->execute();
    }

    public function deleteSpecification()
    {
        $this->db->createCommand("delete from specification where car_id = :id
        ", [':id' => $this->entity->getId()])->execute();
    }

}