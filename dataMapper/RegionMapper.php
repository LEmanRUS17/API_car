<?php

namespace app\dataMapper;

use app\entities\EntityRegion;
use app\interface\MapperInterface;
use Yii;

class RegionMapper implements MapperInterface
{
    private $entity; // entity
    private $db;        // БД

    public function __construct($entity)
    {
        $this->entity = $entity; // Подключение entity
        $this->db = Yii::$app->db; // Подключение Базы данных
    }

    public function create()
    {
        $this->db->createCommand("insert into region (country_id, title) values (:country_id , :title)", [
            ':country_id' => $this->entity->getCountryId(),
            ':title' => $this->entity->getTitle()
        ] )->execute();
    }

    public function delete()
    {
        $this->db->createCommand("delete from region where id = :id", [':id' => $this->entity->getId()])->execute();
    }

    public function list()
    {
        $arr = $this->db->createCommand('select distinct * from region order by id')->queryAll();

        foreach ($arr as $num)
            $list[] = new EntityRegion($num);

        return $list;
    }

    public function get()
    {
        $option = $this->db->createCommand("select * from region where id = :id", [':id' => $this->entity->getId()])->queryOne();

        $this->entity->init($option);
    }
}