<?php

namespace app\interface;

interface StorageInterface // Интерфейс
{
    public function create(); // создать

    public function delete(); // удалить

    public function list(); // просмотреть
}