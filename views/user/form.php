<?php

use atom\bootstrap\ActiveForm;
use atom\cms\forms\UserForm;
use yii\helpers\Html;

?>
<?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'active')->checkbox(); ?>
    <?= $form->field($model, 'username'); ?>
    <?= $form->field($model, 'email'); ?>
    <?= $form->field($model, 'firstName'); ?>
    <?= $form->field($model, 'lastName'); ?>
    <?= $form->field($model, 'roles')->checkboxList(UserForm::getAllRoles()); ?>
    <div class="row">
        <div class="mb-3 col">
            <?= Html::submitButton('Save', ['class' => 'btn btn-primary']); ?>
        </div>
    </div>
<?php ActiveForm::end(); ?>
