<?php

namespace app\interface;

interface CarServicesInterface
{
    public function update(array $arr);

    public function get(int $id);

    public function search(array $arr);
}