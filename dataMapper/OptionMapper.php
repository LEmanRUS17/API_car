<?php

namespace app\dataMapper;

use app\entities\EntityOption;
use app\interface\MapperInterface;
use app\interface\OptionMapperInterface;
use Yii;
use yii\data\SqlDataProvider;

class OptionMapper implements MapperInterface, OptionMapperInterface
{

    private $entity; // entity
    private $db;     // БД

    public function __construct($entity)
    {
        $this->entity = $entity; // Подключение entity
        $this->db = Yii::$app->db; // Подключение Базы данных
    }

    public function createCarOption(int $id = null) // Добавить опции для машины
    {
        $arr = $this->entity->getOptions();

        if ($id == null)
            $id = $this->entity->getId();

        foreach ($arr as $num) {
            $this->db->createCommand("INSERT INTO car_option (car_id, option_id)
            VALUES (:car_id, :option_id)", [
                ':car_id'    => $id,
                ':option_id' => $num->getId(),
            ])->execute();
        }
    }

    public function delete() // Удалить опцию
    {
        $this->db->createCommand("DELETE FROM \"option\" WHERE id = :id", [':id' => $this->entity->getId()])->execute();
    }

    public function deleteOptions() // Удалить опции машины
    {
        $this->db->createCommand("DELETE FROM car_option WHERE car_id = :id
        ", [':id' => $this->entity->getId()])->execute();
    }

    public function get()
    {
        $option = $this->db->createCommand("select * from \"option\" where id = :id", [':id' => $this->entity->getId()])->queryOne();

        $this->entity->init($option);
    }

    public function list()
    {
        $arr = $this->db->createCommand('select distinct * FROM option order by id')->queryAll();

        $result = [];
        foreach ($arr as $elem) {
            $result[] = new EntityOption($elem);
        }

        return $result;
    }

    public function create()
    {
        $this->db->createCommand("insert into \"option\" (title) 
                                        values (:value)", [':value' => $this->entity->getTitle()])->execute();
    }

    public function countList()
    {
        return $this->db->createCommand('SELECT COUNT(*) FROM option')->queryScalar();
    }

    private function entityInit(array $arr)
    {
        $result = [];
        foreach ($arr as $elem)
            $result[] = new EntityOption($elem);

        return $result;
    }

}