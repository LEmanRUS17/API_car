<?php

namespace app\services;

use app\dataMapper\LocalityMapper;
use app\dataMapper\OptionMapper;
use app\entities\EntityLocality;
use app\entities\EntityOption;
use app\interface\ServicesInterface;
use app\storage\LocalityStorage;
use app\storage\OptionStorage;
use app\validators\LocalityValidator;
use Yii;

class LocalityService implements ServicesInterface
{

    private $storage; // хранилище
    private $entity;

    public function __construct(EntityLocality $entity)
    {
        $this->entity = $entity;
        $this->storage = new LocalityStorage(new LocalityMapper($this->entity));
    }

    public function create(array $arr)
    {
        $this->entity->init($arr);

        $validator = new LocalityValidator($this->entity, ['title', 'regionId']);
        if (!$validator->validate())
            return $validator->validate();

        $this->storage->create();

         return ['success' => ['message' => 'Населенный пункт дабавлен']];
    }

    public function delete(int $id)
    {
        $this->entity->init(['id' => $id]);

        $validator = new LocalityValidator($this->entity, ['id']);
        if (!$validator->validate())
            return $validator->validate();

        $this->storage->delete();

        return ['success' => ['message' => 'Населенный пункт удален']];
    }

    public function list()
    {
        $arr = $this->storage->list();

        foreach ($arr as $num)
            $list[] = $num->getAll();

        return $list;
    }

    public function get(array $arr)
    {
        $this->entity->init($arr);

        $validator = new LocalityValidator($this->entity, ['id']);
        if (!$validator->validate())
            return $validator->validate();

        $this->storage->get();

        return $this->entity->getAll();
    }
}