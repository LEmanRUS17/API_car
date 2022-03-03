
<?= ListView::widget([
    'dataProvider' => $dataProvider,
    'itemOptions' => ['class' => 'post'],
    'itemView' => '_post',
    'layout' => '{items}{pager}',
    'pager' => ['registerLinkTags' => true],
]) ?>


    // Можно так:
<?= $this->render('_list', [
    'dataProvider' => $dataProvider
]) ?>