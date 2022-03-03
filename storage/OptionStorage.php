<?php

namespace app\storage;

use app\dataMapper\OptionMapper;
use app\interface\StorageInterface;

class OptionStorage implements StorageInterface
{

    private $mapper;

    public function __construct(OptionMapper $mapper)
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