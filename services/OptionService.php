<?php

namespace app\services;

use app\dataMapper\OptionMapper;
use app\entities\EntityOption;
use app\interface\ServicesInterface;
use app\storage\OptionStorage;
use app\validators\OptionValidator;
use Yii;

class OptionService implements ServicesInterface
{
    private $storage; // хранилище
    private $entity;

    public function __construct(EntityOption $entityOption)
    {
        $this->entity = $entityOption;
        $this->storage = new OptionStorage(new OptionMapper($this->entity));
    }

    public function delete(int $id)
    {
        $this->entity->init(['id' => $id]);
        $this->storage->delete();

        return ['success' => ['message' => 'Опция удалена']];
    }

    public function list()
    {
        $options = $this->storage->list();

        return $this->getEntity($options);
    }

    public function create(array $arr)
    {
        $this->entity->init($arr);

        $validator = new OptionValidator($this->entity, ['title']);
        if (!$validator->validate())
            return $validator->validate();

        $this->storage->create();

        return ['success' => ['message' => 'Опция дабавленна']];
    }

    private function getEntity(array $arr)
    {
       $arrOptions = [];

        foreach ($arr as $elem)
            $arrOptions[] = $elem->getAll();

        return $arrOptions;
    }

    public function get(int $id)
    {
        $this->entity->init(['id' => $id]);

        $validator = new OptionValidator($this->entity, ['id']);
        if (!$validator->validate())
            return $validator->validate();

        $this->storage->get();

        return $this->entity->getAll();

    }
}