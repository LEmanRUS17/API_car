<?php

namespace app\dataMapper;

use app\entities\EntityLocality;
use app\interface\MapperInterface;
use Yii;

class LocalityMapper implements MapperInterface
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
        $this->db->createCommand("insert into locality (region_id, title) values (:region_id , :title)", [
            ':region_id' => $this->entity->getRegionId(),
            ':title' => $this->entity->getTitle()
        ] )->execute();
    }

    public function delete()
    {
        $this->db->createCommand("delete from locality where id = :id", [':id' => $this->entity->getId()])->execute();
    }

    public function list()
    {
        $arr = $this->db->createCommand('select distinct * from locality order by id')->queryAll();

        foreach ($arr as $num)
            $list[] = new EntityLocality($num);

        return $list;
    }

    public function get()
    {
        $locality = $this->db->createCommand("select * from locality where id = :id", [':id' => $this->entity->getId()])->queryOne();

        $this->entity->init($locality);
    }
}