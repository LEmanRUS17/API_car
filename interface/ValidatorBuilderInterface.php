<?php

namespace app\interface;

interface ValidatorBuilderInterface
{
    public function validateTitle(string|null $title);

    public function validateDecoration(string|null $decoration);

    public function validatePrice(int|null $price);

    public function validateUser(int|null $user);

    public function validateLocality(int|null $locality);

    public function validatePhotos(array $photos);

    public function validateBrand(string|null $brand);

    public function validateModel(string|null $model);

    public function validateBody(string|null $body);

    public Function validateMileage(int|null $mileage);

    public function validateYearOfIssue(int|null $year);

    public function validateOptions(int $options, int $key);

    public function getErrors();
}