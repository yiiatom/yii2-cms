<?php

use yii\helpers\Html;

$this->title = $model->getUser()->getDisplayName(true);
$this->params['breadcrumbs'] = [
    ['label' => 'Users', 'url' => ['index']],
    $this->title,
];

?>
<h1><?= Html::encode($this->title) ?></h1>
<?= $this->render('form', [
    'model' => $model,
]) ?>
