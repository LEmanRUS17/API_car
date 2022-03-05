<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
use yii\bootstrap5\Carousel;

$this->title = 'Просмотр автомобиля';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="car-create">
    <h1><?= Html::encode($this->title) ?></h1>

<!--    <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">-->
<!--        <div class="carousel-inner">-->
<!--            --><?php //foreach ($car['photo'] as $photo) {
//
//                echo '<div class="carousel-item">';
//                echo '<img src="' . $photo['photo'] . '" class="d-block w-100" alt="...">';
//                echo '</div>';
//            } ?>
<!--        </div>-->
<!--        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls"  data-bs-slide="prev">-->
<!--            <span class="carousel-control-prev-icon" aria-hidden="true"></span>-->
<!--            <span class="visually-hidden">Предыдущий</span>-->
<!--        </button>-->
<!--        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls"  data-bs-slide="next">-->
<!--            <span class="carousel-control-next-icon" aria-hidden="true"></span>-->
<!--            <span class="visually-hidden">Следующий</span>-->
<!--        </button>-->
<!--    </div>-->

    <div class="container">
        <table class="table table-hover">
            <tr>
                <td>ID</td>
                <td><?= $car['id'] ?></td>
            </tr>
            <tr>
                <td>Название</td>
                <td><?= $car['title'] ?></td>
            </tr>
            <tr>
                <td>Описание</td>
                <td><?= $car['decoration'] ?></td>
            </tr>
            <tr>
                <td>Стоимость</td>
                <td><?= $car['price'] ?></td>
            </tr>
            <tr>
                <td>Бренд</td>
                <td><?= $car['specification']['brand'] ?></td>
            </tr>
            <tr>
                <td>Модель</td>
                <td><?= $car['specification']['model'] ?></td>
            </tr>
            <tr>
                <td>Год выпуска</td>
                <td><?= $car['specification']['year_of_issue'] ?></td>
            </tr>
            <tr>
                <td>Кузов</td>
                <td><?= $car['specification']['body'] ?></td>
            </tr>
            <tr>
                <td>Пробег</td>
                <td><?= $car['specification']['mileage'] ?></td>
            </tr>
            <tr>
                <td>Опции:</td>
                <td>
                <?php foreach($car['options'] as $option)
                    echo $option['title'] . ' ';
                    ?>
                </td>
            </tr>
        </table>

        <?= Html::beginForm(['/front/car/view'], 'GET'); ?>
        <?= Html::textInput('id'); ?>
        <div class="form-group">
            <?= Html::submitButton('POST', ['class' => 'btn btn-primary']); ?>
        </div>
        <?= Html::endForm(); ?>

    </div>
</div>