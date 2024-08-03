<?php

use atom\bootstrap\ActiveForm;
use yii\helpers\Html;

$this->title = 'Change password';
$this->params['breadcrumbs'][] = $this->title;

?>
<h1><?= Html::encode($this->title) ?></h1>
<?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'password')->passwordInput() ?>
    <?= $form->field($model, 'newPassword')->passwordInput() ?>
    <?= $form->field($model, 'confirm')->passwordInput() ?>

    <div class="mb-3">
        <?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
    </div>

<?php ActiveForm::end(); ?>
