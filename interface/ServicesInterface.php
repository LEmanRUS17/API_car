<?php

namespace app\interface;

interface ServicesInterface
{
    public function create(array $arr);

    public function delete(int $id);

    public function list();
}