<?php

namespace app\interface;

interface CarStorageInterface
{
    public function update(); // обновить

    public function get(); // список

    public function search(); // поиск
}