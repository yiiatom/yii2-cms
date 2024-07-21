<?php

use yii\helpers\Html;
use atom\grid\GridView;
use atom\cms\models\Notification;

$this->title = 'Notifications';
$this->params['breadcrumbs'][] = $this->title;

?>
<h1><?= Html::encode($this->title); ?></h1>
<?= GridView::widget([
    'dataProvider' => $model->getDataProvider(),
    'rowOptions' => function($model) {
        $class = '';
        if ($model->type == Notification::TYPE_INFO) {
            $class = 'table-info';
        } elseif ($model->type == Notification::TYPE_SUCCESS) {
            $class = 'table-success';
        } elseif ($model->type == Notification::TYPE_WARNING) {
            $class = 'table-warning';
        } elseif ($model->type == Notification::TYPE_DANGER) {
            $class = 'table-danger';
        }
        return ['class' => $class];
    },
    'columns' => [
        'title',
        'created_at',
    ],
]); ?>
