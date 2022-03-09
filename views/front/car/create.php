<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
use yii\helpers\ArrayHelper;

$this->title = 'Добавить автомобиль';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= Html::beginForm(['/front/car/create'], 'POST', ['enctype' => 'multipart/form-data', 'id' => 'form', 'class' => 'needs-validation', 'novalidate' => 'novalidate']); ?>

        <div class="mb-3 row">
            <label for="staticEmail" class="col-sm-2 col-form-label">Название</label>
            <div class="col-sm-10">
            <?= Html::textInput('title', null,  ['class' => 'form-control', 'required' => 'required']); ?>
                <div class="invalid-feedback">
                    Укажите название автомобиля.
                </div>
            </div>
        </div>

        <div class="mb-3 row">
            <label for="staticEmail" class="col-sm-2 col-form-label">Описание</label>
            <div class="col-sm-10">
                <?= Html::textarea('decoration', null,  ['class' => 'form-control', 'rows' => 3, 'required' => 'required']); ?>
                <div class="invalid-feedback">
                    Добавте описания автомобиля.
                </div>
            </div>
        </div>

        <div class="mb-3 row">
            <label for="staticEmail" class="col-sm-2 col-form-label">Стоимость</label>
            <div class="col-sm-10">
                <?= Html::input('int', 'price', null,  ['class' => 'form-control', 'required' => 'required']); ?>
                <div class="invalid-feedback">
                    Укажите стоимость автомобиля.
                </div>
            </div>
        </div>

        <div class="mb-3 row">
            <label for="staticEmail" class="col-sm-2 col-form-label">Владелец</label>
            <div class="col-sm-10">
                <?= Html::textInput('user', null,  ['class' => 'form-control', 'required' => 'required']); ?>
            </div>
        </div>

        <div class="mb-3 row">
            <label for="exampleDataList" class="form-label col-sm-2">Местоположение</label>
            <div class="col-sm-10">
                <?= Html::dropDownList('locality', null, ArrayHelper::map($locations, 'id', 'title'), ['class' => 'form-select', 'aria-label' => '.form-select-lg example']) ?>
                <div class="invalid-feedback">
                    Укажите местоположение автомобиля.
                </div>
            </div>
        </div>

        <?= Html::button('Добавить спецификации', ['class' => 'btn btn-primary btn-lg', 'id' => 'butSpecification']); ?>

        <div id = "specification" class="d-none p-3">
            <div class="mb-3 row">
                <label for="exampleDataList" class="col-sm-2 col-form-label">Бренд</label>
                <div class="col-sm-10">
                    <?= Html::textInput('specification[brand]', null,  ['class' => 'form-control specification', 'disabled' => true]); ?>
                </div>
            </div>

            <div class="mb-3 row">
                <label for="exampleDataList" class="col-sm-2 col-form-label">Модель</label>
                <div class="col-sm-10">
                    <?= Html::textInput('specification[model]', null,  ['class' => 'form-control specification', 'disabled' => true]); ?>
                </div>
            </div>

            <div class="mb-3 row">
                <label for="exampleDataList" class="col-sm-2 col-form-label">Кузов</label>
                <div class="col-sm-10">
                    <?= Html::textInput('specification[body]', null,  ['class' => 'form-control specification', 'disabled' => true]); ?>
                </div>
            </div>

            <div class="mb-3 row">
                <label for="exampleDataList" class="col-sm-2 col-form-label">Пробег</label>
                <div class="col-sm-10">
                    <?= Html::input('int','specification[mileage]', null,  ['class' => 'form-control specification', 'disabled' => true]); ?>
                </div>
            </div>

            <div class="mb-3 row">
                <label for="exampleDataList" class="col-sm-2 col-form-label">Год выпуска</label>
                <div class="col-sm-10">
                    <?= Html::input('int','specification[year_of_issue]', null,  ['class' => 'form-control specification', 'disabled' => true]); ?>
                </div>
            </div>
        </div>

        <div class="mb-3 row p-3" id="options">
<!--           <?//= Html::button('Добавить опцию', ['class' => 'btn btn-primary btn-lg', 'onclick' => 'add_field()']); ?> -->
            <label for="exampleDataList" class="col-sm-2 col-form-label">Опции:</label>
            <div class="col-sm-10">
                <?= Html::checkboxList('options', null, ArrayHelper::map($options, 'id', 'title')) ?>
            </div>
        </div>

        <div class="mb-3 row">
            <label for="formFileDisabled" class="form-label">Фото:</label>
            <div class="col-sm-10">
                <?= Html::fileInput('photos[]', null, ['multiple' => true, 'class' => 'form-control', 'id'=>"formFileDisabled"]); ?>
            </div>
        </div>

        <div class="form-group">
            <?= Html::submitButton('Создать', ['class' => 'btn btn-primary btn-lg']); ?>
        </div>

    <?= Html::endForm(); ?>
</div>