<?php

namespace app\services;

use app\dataMapper\RegionMapper;
use app\entities\EntityRegion;
use app\interface\ServicesInterface;
use app\storage\RegionStorage;
use app\validators\RegionValidator;
use Yii;
use yii\validators\Validator;

class RegionService implements ServicesInterface
{

    private $storage; // хранилище
    private $entity;

    public function __construct(EntityRegion $entityOption)
    {
        $this->entity = $entityOption;
        $this->storage = new RegionStorage(new RegionMapper($this->entity));
    }

    public function create(array $arr)
    {
        $this->entity->init($arr);

        $validator = new RegionValidator($this->entity, ['title', 'countryId']);
        if (!$validator->validate())
            return $validator->validate();

        $this->storage->create();

        return ['success' => ['message' => 'Регион дабавлен']];
    }

    public function delete(int $id)
    {
        $this->entity->init(['id' => $id]);

        $validator = new RegionValidator($this->entity, ['id']);
        if (!$validator->validate())
            return $validator->validate();

        $this->storage->delete();

        return ['success' => ['message' => 'Регион удален']];
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

        $validator = new RegionValidator($this->entity, ['id']);
        if (!$validator->validate())
            return $validator->validate();

        $this->storage->get();

        return $this->entity->getAll();
    }
}