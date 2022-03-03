<?php

namespace app\entities;

class EntityOption
{
    private int|null $id = null;
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

    public function getAll()
    {
        return [
            'id'    => $this->id,
            'title' => $this->title
        ];
    }
}