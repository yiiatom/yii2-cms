<?php

use yii\helpers\Html;

$this->title = 'Create user';
$this->params['breadcrumbs'] = [
    ['label' => 'Users', 'url' => ['index']],
    $this->title,
];

?>
<h1><?= Html::encode($this->title) ?></h1>
<?= $this->render('form', [
    'model' => $model,
]) ?>
