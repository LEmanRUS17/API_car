<?php

namespace app\services;

use app\components\YourLinkPager;
use app\dataMapper\UserMapper;
use app\entities\EntityUser;
use app\interface\ServicesInterface;
use app\storage\UserStorage;
use app\validators\UserValidate;
use Yii;
use yii\data\ArrayDataProvider;

class UserService implements ServicesInterface
{
    private $storage; // хранилище
    private $entity;

    public function __construct(EntityUser $entity)
    {
        $this->entity = new $entity;
        $this->storage = new UserStorage(new UserMapper($this->entity));
    }

    public function create(array $arr)
    {
        $this->entity->init($arr);

        $validator = new UserValidate($this->entity, ['lastname', 'firstname', 'surname', 'telephone']);
        if (!$validator->validate())
            return $validator->validate();

        $this->storage->create();

        return ['success' => ['message' => 'Владелец создан']];
    }

    public function delete(int $id)
    {
        $this->entity->init(['id' => $id]);

        $validator = new UserValidate($this->entity, ['id']);
        if (!$validator->validate())
            return $validator->validate();

        $this->storage->delete();

        return ['success' => ['message' => 'Владелец удален']];
    }

    public function get(int $id)
    {
        $this->entity->init(['id' => $id]);

        $validator = new UserValidate($this->entity, ['id']);
        if (!$validator->validate())
            return $validator->validate();

        $this->storage->get();

        return $this->entity->getAll();
    }

    public function update(array $arr)
    {
        $this->entity->init($arr);

        $this->storage->update();

        return ['success' => ['message' => 'Владелец обновлен']];
    }

    public function list()
    {
        $dataProvider = $this->storage->list();

        $arr = $dataProvider->getModels();
        $result = $this->getEntity($arr);
        $dataProvider->setModels($result);

        return $dataProvider;
    }

    private function getEntity(array $arr)
    {
        foreach ($arr as $elem)
            $result[] = $elem->getAll();

        return $result;
    }

    public function listUser()
    {
        $arr = $this->storage->listUser();

        foreach ($arr as $num)
            $list[] = $num->getAll();

        return $list;
    }
}