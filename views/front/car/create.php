<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please fill out the following fields to login:</p>

    <?= Html::beginForm(['/controllers/back/create', 'POST']); ?>
    <?= Html::textarea('KOMENTAR', '', ['rows' => 6]); ?>
    <div class="form-group">
        <?= Html::submitButton('POST', ['class' => 'btn btn-primary']); ?>
    </div>
    <?= Html::endForm(); ?>


    <div class="offset-lg-1" style="color:#999;">
        You may login with <strong>admin/admin</strong> or <strong>demo/demo</strong>.<br>
        To modify the username/password, please check out the code <code>app\models\User::$users</code>.
    </div>
</div>
