<?php

namespace app\builders;

use app\entities\EntityCar;
use app\entities\EntityLocality;
use app\entities\EntityOption;
use app\entities\EntityUser;
use app\interface\ValidatorBuilderInterface;
use app\services\CarService;
use app\services\LocalityService;
use app\services\OptionService;
use app\services\UserService;
use Yii;
use yii\validators\DateValidator;
use yii\validators\NumberValidator;
use yii\validators\StringValidator;

class ValidatorBuilder implements ValidatorBuilderInterface
{
    private $errors = [];

    private $extension = ['jpg', 'png'];
    private $minPrice;
    private $maxPrice;

    private $validatorStr;
    private $validatorInt;
    private $validationId;
    private $validatorMileage;
    private $validatorYear;

    private $users;
    private $locality;
    private $option;

    public function __construct()
    {
        $this->minPrice = Yii::$app->params['min_price'];
        $this->maxPrice = Yii::$app->params['max_price'];

        $this->validatorStr = new StringValidator(['min' => 3, 'max' => 255]);
        $this->validatorInt = new NumberValidator(['min' => $this->minPrice, 'max' => $this->maxPrice]);
        $this->validationId = new NumberValidator(['min' => 1, 'max' => 100000000]);
        $this->validatorMileage = new NumberValidator(['min' => Yii::$app->params['min_mileage'], 'max' => Yii::$app->params['max_mileage']]);
        $this->validatorYear = new DateValidator(['format' => 'php:Y', 'max' => Yii::$app->params['max_year'], 'min' => Yii::$app->params['min_year']]);

        $this->car = new CarService(new EntityCar([]), new EntityOption());
        $this->users = new UserService(new EntityUser());
        $this->locality = new LocalityService(new EntityLocality());
        $this->option = new OptionService(new EntityOption());
    }

    public function validateId(int|null $id)
    {
        if(empty($id))
            $this->errors[] = 'Поле title должно быть заполнено';
        elseif (!$this->validationId->validate($id))
            $this->errors[] = 'id пользователя должен быть числом от 1 до 100000000';

        $c = false;
        $arr = $this->car->listCar();
        foreach ($arr as $num) {
            if($num == $id)
                $c = true;
        }
        if ($c == false)
            $this->errors[] = 'Такой записи не существует';
    }

    public function validateTitle(string|null $title)
    {
        if (empty($title))
            $this->errors[] = 'Поле title должно быть заполнено';
        elseif (!$this->validatorStr->validate($title))
            $this->errors[] = 'Размер названия должен быть от 3 до 255';
    }

    public function validateDecoration(string|null $decoration)
    {
        if (empty($decoration))
            $this->errors[] = 'Поле decoration должно быть заполнено';
        elseif (!$this->validatorStr->validate($decoration))
            $this->errors[] = 'Размер описания должен быть от 3 до 255';
    }

    public function validatePrice(int|null $price)
    {
        if (empty($price))
            $this->errors[] = 'Поле price должно быть заполнено и являтся числом';
        if (!$this->validatorInt->validate($price))
            $this->errors[] = 'Максимальная стоимость ' . Yii::$app->params['max_price'];
    }

    public function validateUser(int|null $user)
    {
        if (empty($user))
            $this->errors[] = 'Поле user должно быть заполнено';
        elseif (!$this->validationId->validate($user) and !is_object($user))
            $this->errors[] = 'id пользователя должен быть числом от 1 до 100000000';

        $u = false;
        $arr = $this->users->listUser();
        foreach ($arr as $num) {
            if($num['id'] == $user)
                $u = true;
        }
        if ($u == false)
            $this->errors[] = 'Такой пользователь не существует';
    }

    public function validateLocality(int|null $locality)
    {
        if (empty($locality))
            $this->errors[] = 'Поле locality должно быть заполнено';
        elseif (!$this->validationId->validate($locality))
            $this->errors[] = 'id местоположения должен быть числом от 1 до 100000000';

        $local = false;
        $arr = $this->locality->list();
        foreach ($arr as $num) {
            if($num['id'] == $locality)
                $local = true;
        }
        if ($local == false)
            $this->errors[] = 'Такого населеного пункта не существует';
    }

    public function validatePhotos(array $photos)
    {
        if(empty($photos)) {
            $this->errors[] = 'Должна быть выбранна хотябы одна фотография';
        } else {
            foreach ($photos as $num) {
                if (!$this->extensionCheck($num->extension))
                    $this->errors[] = 'Неверный формат изображения';

                if ($num->size == 0)
                    $this->errors[] = 'Изображение должно быть не больше 7 Мб.';

                if ($num->size > 7340032 and $num->size < 10000)
                    $this->errors[] = 'Изображение должно быть не больше 7 Мб и не меньше 9,77 Кб.';
            }
        }
    }

    private function extensionCheck(string $value)
    {
        foreach ($this->extension as $num) {
            if ($num == $value)
                return true;
        }

        return false;
    }

    public function validateBrand(string|null $brand)
    {
        if (empty($brand))
            $this->errors[] = 'Поле brand должно быть заполнено';
        elseif (!$this->validatorStr->validate($brand))
            $this->errors[] = 'Размер поля `бренд` должен быть от 3 до 255';
    }

    public function validateModel(string|null $model)
    {
        if (empty($model))
            $this->errors[] = 'Поле model должно быть заполнено';
        elseif (!$this->validatorStr->validate($model))
            $this->errors[] = 'Размер поля `модель` должен быть от 3 до 255';
    }

    public function validateBody(string|null $body)
    {
        if (empty($body))
            $this->errors[] = 'Поле body должно быть заполнено';
        elseif (!$this->validatorStr->validate($body))
            $this->errors[] = 'Размер поля `кузов` должен быть от 3 до 255';
    }

    public function validateMileage(int|null $mileage)
    {
        if (empty($mileage))
            $this->errors[] = 'Поле mileage должно быть заполнено и являтся числом';
        elseif (!$this->validatorMileage->validate($mileage))
            $this->errors[] = 'Превышем максимальный пробег';
    }

    public function validateYearOfIssue(int|null $year)
    {
        if (empty($year))
            $this->errors[] = 'Поле year_of_issue должно быть заполнено и являтся числом';
        elseif (!$this->validatorYear->validate($year, $errors)) {
            $this->errors[] = 'Год выпуска должен быть в диапазоне: от ' . Yii::$app->params['min_year'] . ' до ' . Yii::$app->params['max_year'];
        }
    }

    public function validateOptions(int $options, int $key)
    {
        if (empty($options))
            $this->errors[] = 'Поля опций должны быть заполнены и быть числом';

        $arrOptions = $this->option->list();
        $option = false;
        foreach ($arrOptions as $elem) {
            if ($elem['id'] == $options)
                $option = true;
        }
        if ($option == false)
            $this->errors[] = 'Опции №' . $key + 1 . ' не существует';
    }

    public function validateMinMaxPrice(int $min, int $max)
    {
        if ( $min > $max)
            $this->errors[] = 'Минимальная стоимость не должна быть больше максимальной';

        if (!$this->validatorInt->validate($min))
            $this->errors[] = 'Нижний диапазон цены должен быть в пределах от ' . $this->minPrice . ' до ' . $this->maxPrice;

        if (!$this->validatorInt->validate($max))
            $this->errors[] = 'Верхний диапазон цены должен быть в пределах от ' . $this->minPrice . ' до ' . $this->maxPrice;
    }

    public function validateMinMaxYear(int $min, int $max)
    {

        if ( $min > $max)
            $this->errors[] = 'Минимальный год выпуска не должен быть больше максимального';

        if (!$this->validatorYear->validate($min))
            $this->errors[] = 'Нижний диапазон года выпуска должен быть в пределах от ' . Yii::$app->params['min_year'] . ' до ' . Yii::$app->params['max_year'];

        if (!$this->validatorYear->validate($max))
            $this->errors[] = 'Верхний диапазон года выпуска должен быть в пределах от ' . Yii::$app->params['min_year'] . ' до ' . Yii::$app->params['max_year'];
    }

    public function validateMinMaxMileage(int $min, int $max)
    {
        if ( $min > $max)
            $this->errors[] = 'Минимальный пробег не должен быть больше максимального';

        if (!$this->validatorMileage->validate($min))
            $this->errors[] = 'Нижний диапазон пробега должен быть в пределах от ' . Yii::$app->params['min_mileage'] . ' до ' . Yii::$app->params['max_mileage'];

        if (!$this->validatorMileage->validate($max))
            $this->errors[] = 'Верхний диапазон пробега должен быть в пределах от ' . Yii::$app->params['min_mileage'] . ' до ' . Yii::$app->params['max_mileage'];
    }


    public function getErrors()
    {
        return $this->errors;
    }
}