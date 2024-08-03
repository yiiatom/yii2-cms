<?php

use atom\bootstrap\ActiveForm;
use yii\helpers\Html;

$this->title = $model->getUser()->getDisplayName();
$this->params['breadcrumbs'] = [
    ['label' => 'Users', 'url' => ['index']],
    $this->title,
];

?>
<h1><?= Html::encode($this->title) ?></h1>
<?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'password')->passwordInput() ?>
    <?= $form->field($model, 'confirm')->passwordInput() ?>
    <?= $form->field($model, 'changeAfterLogin')->checkbox() ?>
    <div class="row">
        <div class="mb-3 col">
            <?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
        </div>
    </div>
<?php ActiveForm::end(); ?>
