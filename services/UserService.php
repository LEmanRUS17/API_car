<?php

namespace app\services;

use app\components\YourLinkPager;
use app\dataMapper\UserMapper;
use app\entities\EntityUser;
use app\interface\ServicesInterface;
use app\storage\UserStorage;
use app\validators\GetUserValidate;
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

        $validate = new UserValidate($this->entity);
        $validate->validate();

        $this->storage->create();

        return ['success' => ['message' => 'Владелец создан']];
    }

    public function delete(int $id)
    {
        $this->entity->init(['id' => $id]);

        $validate = new GetUserValidate($this->entity);
        $validate->validate();

        $this->storage->delete();

        return ['success' => ['message' => 'Владелец удален']];
    }

    public function get(int $id)
    {
        $this->entity->init(['id' => $id]);

        $validate = new GetUserValidate($this->entity);
        $validate->validate();

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