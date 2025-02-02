<?php

use yii\helpers\Html;
use atom\grid\GridView;
use atom\cms\models\Notification;

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;

?>
<h1><?= Html::encode($this->title) ?></h1>
<div class="mb-3">
    <?= Html::a('Create', ['create'], ['class' => 'btn btn-primary']) ?>
</div>
<?= GridView::widget([
    'dataProvider' => $filter->getDataProvider([], true),
    'rowOptions' => function($model) {
        $options = [];
        if (!$model->active) {
            Html::addCssClass($options, 'table-secondary');
        }
        return $options;
    },
    'columns' => [
        'id',
        'displayName',
        'username',
        [
            'attribute' => 'active',
            'content' => function($model) {
                return $model->active ? '<i class="fa-solid fa-check text-success"></i>' : '';
            },
        ],
        'email',
        [
            'class' => 'atom\grid\ActionColumn',
            'template' => '{update} {password}',
            'buttons' => [
                'password' => function($url, $model, $key) {
                    return Html::a('<i class="fa-solid fa-lock"></i>', $url, ['title' => 'Change password']);
                },
            ],
        ],
    ],
]); ?>
