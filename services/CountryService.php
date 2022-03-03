<?php

namespace app\services;

use app\dataMapper\CountryMapper;
use app\entities\EntityCountry;
use app\interface\ServicesInterface;
use app\storage\CountryStorage;
use app\validators\CountryValidator;
use app\validators\GetUserValidate;
use Yii;

class CountryService implements ServicesInterface
{
    private $storage; // хранилище
    private $entity;

    public function __construct( EntityCountry $entity)
    {
        $this->entity = $entity;

        $this->storage = new CountryStorage(new CountryMapper($this->entity));
    }

    public function create(array $arr)
    {
        $this->entity->init($arr);

        $validator = new CountryValidator($this->entity);
        $validator->validate();

        $this->storage->create();

        return ['success' => ['message' => 'Страна дабавленна']];
    }

    public function delete(int $id)
    {
        $this->entity->init(['id' => $id]);

        $this->storage->delete();

        return ['success' => ['message' => 'Страна удалена']];
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
        $this->storage->get();

        return $this->entity->getAll();
    }
}