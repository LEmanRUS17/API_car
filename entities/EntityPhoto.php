<?php

namespace app\entities;

use yii\helpers\Html;
use yii\web\UploadedFile;

class EntityPhoto
{
    private int|null $id = null;
    private UploadedFile|string|null $photo = null;
    private int|null $car_id = null;

    public function __construct(array|null $arr)
    {
        $this->init($arr);
    }

    public function init(array|null $arr)
    {
        if (isset($arr))
            foreach ($arr as $key => $num) {
                try {
                    $this->$key = $num;
                } catch (\TypeError) {}
            }
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string|UploadedFile|null
     */
    public function getPhoto(): UploadedFile|string|null
    {
        return $this->photo;
    }

    /**
     * @param string|UploadedFile|null $photo
     */
    public function setPhoto(UploadedFile|string|null $photo): void
    {
        $this->photo = $photo;
    }

    /**
     * @return int|null
     */
    public function getCarId(): ?int
    {
        return $this->car_id;
    }

    /**
     * @param int|null $car_id
     */
    public function setCarId(?int $car_id): void
    {
        $this->car_id = $car_id;
    }

    public function getAll()
    {
        return [
            'id' => $this->id,
            'photo' => $this->photo,
            'car_id' => $this->car_id
        ];
    }
}