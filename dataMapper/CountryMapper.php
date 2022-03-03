<?php

namespace app\dataMapper;

use app\entities\EntityCountry;
use app\interface\MapperInterface;
use Yii;

class CountryMapper implements MapperInterface
{
    private $entity; // entity
    private $db;     // БД

    public function __construct($entity)
    {
        $this->entity = $entity; // Подключение entity
        $this->db = Yii::$app->db; // Подключение Базы данных
    }

    public function  create()
    {
        $this->db->createCommand("insert into country (title) 
                                        values (:value)", [':value' => $this->entity->getTitle()])->execute();
    }

    public function delete()
    {
        $this->db->createCommand("delete from country where id = :id", [':id' => $this->entity->getId()])->execute();
    }

    public function list()
    {
        $arr = $this->db->createCommand('select distinct * from country order by id')->queryAll();

        $list = [];
        foreach ($arr as $num)
            $list[] = new EntityCountry($num);

        return $list;
    }

    public function get()
    {
        $country = $this->db->createCommand("select * from country where id = :id", [':id' => $this->entity->getId()])->queryOne();

        $this->entity->init($country);
    }
}