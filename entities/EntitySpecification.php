<?php

namespace app\entities;

use TypeError;
use Yii;
use yii\base\Exception;

class EntitySpecification
{
    private int|null $id = null;
    private int|null $car_id = null;
    private string|null $brand = null;
    private string|null $model = null;
    private int|null $year_of_issue = null;
    private string|null $body = null;
    private int|null $mileage = null;

    // search:
    private int|null $min_year = null;
    private int|null $max_year = null;
    private int|null $min_mileage = null;
    private int|null $max_mileage = null;

    public function __construct(array $arr = [])
    {
        $this->init($arr);
    }

    public function init(array $arr)
    {
        foreach ($arr as $key => $num)
        {
            try {
                $this->$key = $num;
            } catch (TypeError) {}
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

    /**
     * @return string|null
     */
    public function getBrand(): ?string
    {
        return $this->brand;
    }

    /**
     * @param string|null $brand
     */
    public function setBrand(?string $brand): void
    {
        $this->brand = $brand;
    }

    /**
     * @return string|null
     */
    public function getModel(): ?string
    {
        return $this->model;
    }

    /**
     * @param string|null $model
     */
    public function setModel(?string $model): void
    {
        $this->model = $model;
    }

    /**
     * @return int|null
     */
    public function getYearOfIssue(): ?int
    {
        return $this->year_of_issue;
    }

    /**
     * @param int|null $year_of_issue
     */
    public function setYearOfIssue(?int $year_of_issue): void
    {
        $this->year_of_issue = $year_of_issue;
    }

    /**
     * @return string|null
     */
    public function getBody(): ?string
    {
        return $this->body;
    }

    /**
     * @param string|null $body
     */
    public function setBody(?string $body): void
    {
        $this->body = $body;
    }

    /**
     * @return int|null
     */
    public function getMileage(): ?int
    {
        return $this->mileage;
    }

    /**
     * @param int|null $mileage
     */
    public function setMileage(?int $mileage): void
    {
        $this->mileage = $mileage;
    }

    /**
     * @return int|null
     */
    public function getMinYear(): ?int
    {
        return $this->min_year;
    }

    /**
     * @param int|null $min_year
     */
    public function setMinYear(?int $min_year): void
    {
        $this->min_year = $min_year;
    }

    /**
     * @return int|null
     */
    public function getMaxYear(): ?int
    {
        return $this->max_year;
    }

    /**
     * @param int|null $max_year
     */
    public function setMaxYear(?int $max_year): void
    {
        $this->max_year = $max_year;
    }

    /**
     * @return int|null
     */
    public function getMinMileage(): ?int
    {
        return $this->min_mileage;
    }

    /**
     * @param int|null $min_mileage
     */
    public function setMinMileage(?int $min_mileage): void
    {
        $this->min_mileage = $min_mileage;
    }

    /**
     * @return int|null
     */
    public function getMaxMileage(): ?int
    {
        return $this->max_mileage;
    }

    /**
     * @param int|null $max_mileage
     */
    public function setMaxMileage(?int $max_mileage): void
    {
        $this->max_mileage = $max_mileage;
    }

    public function getAll()
    {
        if(!$this->id == null)
        return [
            'id'            => $this->id,
            'car_id'        => $this->car_id,
            'brand'         => $this->brand,
            'model'         => $this->model,
            'year_of_issue' => $this->year_of_issue,
            'body'          => $this->body,
            'mileage'       => $this->mileage,
        ];
    }
}