<?php

use atom\bootstrap\ActiveForm;
use yii\helpers\Html;

?>
<?php $form = ActiveForm::begin([
    'options' => ['class' => 'login-form card p-3 shadow-sm'],
]); ?>
    <?= $form->field($model, 'username', [
        'inputOptions' => ['class' => 'form-control', 'placeholder' => Html::encode($model->getAttributeLabel('username'))],
    ])->label(false); ?>
    <?= $form->field($model, 'password', [
        'inputOptions' => ['class' => 'form-control', 'placeholder' => Html::encode($model->getAttributeLabel('password'))],
    ])->label(false)->passwordInput(); ?>
    <div class="row login-bottom">
        <div class="col">
            <?= $form->field($model, 'rememberMe', [
            ])->checkbox(); ?>
        </div>
        <div class="mb-3 button-login col">
            <?= Html::submitButton('Login', ['class' => 'btn btn-primary']); ?>
        </div>
    </div>
<?php ActiveForm::end(); ?>
