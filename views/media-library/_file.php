<?php

use yii\helpers\Html;

$isImage = @getimagesize($model) ? true : false;
if (!$isImage && mime_content_type($model) === 'image/svg+xml') {
    $isImage = true;
}

?>
<div class="card card-media-library">
    <div class="card-img-top">
        <?php if ($isImage): ?>
            <?= Html::img(Yii::getAlias('@web/public/') . basename($model)) ?>
        <?php else: ?>
            <i class="fa-regular fa-file"></i>
        <?php endif; ?>
    </div>
    <div class="card-body d-flex flex-column">
        <div class="card-title"><?= Html::encode(basename($model)) ?></div>
        <div class="mt-auto">
            <?= Html::a('Delete', ['delete', 'name' => basename($model)], [
                'class' => 'link-danger',
                'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                'data-method' => 'post',
            ]) ?>
        </div>
    </div>
</div>
