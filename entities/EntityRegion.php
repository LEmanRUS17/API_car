<?php

namespace app\entities;

class EntityRegion
{
    private int|null $id = null;
    private int|null $country_id = null;
    private string|null $title = null;

    public function __construct(array $arr = [])
    {
        $this->init($arr);
    }

    public function init(array $arr)
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
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string|null $title
     */
    public function setTitle(?string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return int|null
     */
    public function getCountryId(): ?int
    {
        return $this->country_id;
    }

    /**
     * @param int|null $country_id
     */
    public function setCountryId(?int $country_id): void
    {
        $this->country_id = $country_id;
    }

    public function getAll()
    {
        return [
            'id' => $this->id,
            'country_id' => $this->country_id,
            'title' => $this->title
        ];
    }
}