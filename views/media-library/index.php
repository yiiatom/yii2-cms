<?php

use atom\widgets\ListView;
use yii\data\ArrayDataProvider;
use yii\helpers\Html;

use atom\bootstrap\ActiveForm;

$this->title = 'Media library';
$this->params['breadcrumbs'][] = $this->title;

?>
<h1><?= Html::encode($this->title) ?></h1>
<div class="mb-3">
    <?php $form = ActiveForm::begin(['id' => 'media-library', 'options' => ['enctype' => 'multipart/form-data']]) ?>
        <?= $form->field($model, 'file', ['options' => ['class' => 'd-none']])->fileInput() ?>
        <?= Html::button('Upload', ['class' => 'btn btn-primary btn-upload']) ?>
    <?php ActiveForm::end() ?>
</div>
<?= ListView::widget([
    'dataProvider' => new ArrayDataProvider([
        'allModels' => $files,
    ]),
    'layout' => '{summary}<div class="row">{items}</div>{pager}',
    'itemView' => '_file',
    'itemOptions' => ['class' => 'mb-3 col-6 col-sm-4 col-lg-3'],
]) ?>
