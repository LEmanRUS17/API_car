<?php

namespace app\storage;

use app\dataMapper\LocalityMapper;
use app\interface\StorageInterface;

class LocalityStorage implements StorageInterface
{

    private $mapper;

    public function __construct(LocalityMapper $mapper)
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

    public function list()
    {
        return $this->mapper->list();
    }

    public function get()
    {
        $this->mapper->get();
    }
}