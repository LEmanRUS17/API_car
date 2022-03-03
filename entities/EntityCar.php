<?php

namespace app\entities;

use phpDocumentor\Reflection\Types\Integer;
use Yii;
use yii\base\ErrorException;
use yii\base\Exception;
use yii\web\Response;
use yii\web\UploadedFile;


class EntityCar
{
    // содержание:
    // Столбцы из таблицы
    // Get и Set
    private int $id;
    private string|null $title = null;
    private string|null $decoration = null;
    private int|null $price = null;
    private array|UploadedFile|null $photos = [];
    private int|EntityUser|null $user = null;
    private array|int|null $locality = null;
    public EntitySpecification|null $specification = null;
    public EntityOption|array|null $options = [];

    // search:
    private int|null $min_price = null;
    private int|null $max_price = null;

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
                } catch (\TypeError) {
                }
            }
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
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
     * @return string|null
     */
    public function getDecoration(): ?string
    {
        return $this->decoration;
    }

    /**
     * @param string|null $decoration
     */
    public function setDecoration(?string $decoration): void
    {
        $this->decoration = $decoration;
    }

    /**
     * @return int|null
     */
    public function getPrice(): ?int
    {
        return $this->price;
    }

    /**
     * @param int|null $price
     */
    public function setPrice(?int $price): void
    {
        $this->price = $price;
    }

    /**
     * @return array|UploadedFile|null
     */
    public function getPhotos(): UploadedFile|array|null
    {
        return $this->photos;
    }

    /**
     * @param array|UploadedFile|null $photos
     */
    public function setPhotos(UploadedFile|array|null $photos): void
    {
        $this->photos = $photos;
    }

    /**
     * @return EntityUser|int|null
     */
    public function getUser(): EntityUser|int|null
    {
        return $this->user;
    }

    /**
     * @param EntityUser|int|null $user
     */
    public function setUser(EntityUser|int|null $user): void
    {
        $this->user = $user;
    }

    /**
     * @return EntityLocality|array|int|null
     */
    public function getLocality(): int|array|EntityLocality|null
    {
        return $this->locality;
    }

    /**
     * @param EntityLocality|array|int|null $locality
     */
    public function setLocality(int|array|EntityLocality|null $locality): void
    {
        $this->locality = $locality;
    }

    /**
     * @return EntitySpecification|null
     */
    public function getSpecification(): ?EntitySpecification
    {
        return $this->specification;
    }

    /**
     * @param EntitySpecification|null $specification
     */
    public function setSpecification(?EntitySpecification $specification): void
    {
        $this->specification = $specification;
    }

    /**
     * @return EntityOption|array|null
     */
    public function getOptions(): array|EntityOption|null
    {
        return $this->options;
    }

    /**
     * @param EntityOption|array|null $options
     */
    public function setOptions(array|EntityOption|null $options): void
    {
        $this->options = $options;
    }

    /**
     * @return int|null
     */
    public function getMinPrice(): ?int
    {
        return $this->min_price;
    }

    /**
     * @param int|null $min_price
     */
    public function setMinPrice(?int $min_price): void
    {
        $this->min_price = $min_price;
    }

    /**
     * @return int|null
     */
    public function getMaxPrice(): ?int
    {
        return $this->max_price;
    }

    /**
     * @param int|null $max_price
     */
    public function setMaxPrice(?int $max_price): void
    {
        $this->max_price = $max_price;
    }

    public function getAll()
    {
        $arr = $this->getOptions();
        $option = [];
        if (!empty($arr[0])) {
            foreach ($this->options as $elem) {
                $option[] = $elem->getAll();
            }
        }

        $specification = null;
        if (isset($this->specification))
            $specification = $this->getSpecification()->getAll();

        $photos = [];
        foreach ($this->photos as $num)
            $photos[] = $num->getAll();

        $locality = [];
        if (!empty($this->locality)) {
            foreach ($this->locality as $key => $num) {
                $locality[$key] = $num->getAll();
            }
        }

        //!!!//
        $user = null;
        if (!empty($this->user))
            $user = $this->user->getAll();
        //!!!//

        return [
            'id' => $this->id,
            'title' => $this->title,
            'decoration' => $this->decoration,
            'price' => $this->price,
            'photo' => $photos,
            'locality' => $locality,
            'specification' => $specification,
            'options' => $option,
            'user' => $user
        ];
    }
}