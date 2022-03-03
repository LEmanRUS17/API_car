<?php

namespace app\dataMapper;

use app\entities\EntityCar;
use app\interface\MapperInterface;
use Yii;

class ImageMapper implements MapperInterface
{
    private $entity; // entity
    private $db;        // БД

    public function __construct(EntityCar $entity)
    {
        $this->entity = $entity; // Подключение entity
        $this->db = Yii::$app->db; // Подключение Базы данных
    }

    public function create(int $id = null)
    {
        $arr = $this->entity->getPhotos();

        if ($id == null )
            $id = $this->entity->getId();

        foreach ($arr as $num) {
            $this->db->createCommand("INSERT INTO image (photo, car_id)
            VALUES (:photo, :car_id)", [
                ':photo' => $num,
                ':car_id' => $id
            ])->execute();
        }
    }

    public function deletePhotos()
    {
        $this->db->createCommand("DELETE FROM image WHERE car_id = :id
        ", [':id' => $this->entity->getId()])->execute();
    }

    public function delete()
    {
        // TODO: Implement delete() method.
    }

    public function list()
    {
        // TODO: Implement list() method.
    }
}