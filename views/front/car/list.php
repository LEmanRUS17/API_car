<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\widgets\LinkPager;

$this->title = 'Список автомобилей';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php foreach ($models as $car ) : ?>
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
    <?php endforeach; ?>

    <?= GridView::widget([
        'dataProvider' => $pages,
        'columns' => [
            // ['class' => 'yii\grid\SerialColumn'],
            'tgl',
            'banyak',
        ],
    ]);
    ?>

</div>
