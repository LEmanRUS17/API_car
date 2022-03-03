<?php

namespace app\storage;

use app\dataMapper\RegionMapper;
use app\interface\StorageInterface;

class RegionStorage implements StorageInterface
{

    private $mapper;

    public function __construct(RegionMapper $mapper)
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