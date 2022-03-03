<?php

namespace app\storage;

use app\dataMapper\UserMapper;
use app\interface\StorageInterface;
use Yii;

class UserStorage implements StorageInterface
{
    private $mapper;
    private $specificationMapper;
    private $optionMapper;

    public function __construct(UserMapper $mapper)
    {
        $this->mapper = $mapper;
    }

    public function create()
    {
        $this->mapper->create();
    }

    public function delete()
    {
        $this->mapper->delete();
    }

    public function get()
    {
        $this->mapper->get();
    }

    public function update()
    {
        $this->mapper->update();
    }

    public function list()
    {
        return $this->mapper->list();
    }

    public function listUser()
    {
        return $this->mapper->listUser();
    }
}