<?php

use yii\widgets\ListView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ArrayDataProvider */
$this->title = 'test';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="border-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <p><?= Html::a('Создать', ['create'], ['class' => 'btn btn-success']) ?></p>

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => '_list',
    ]);
    ?>

</div>