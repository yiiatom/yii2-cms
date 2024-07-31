<?php

use atom\cms\assets\AppAsset;
use atom\bootstrap\Breadcrumbs;
use atom\cms\widgets\Alert;
use yii\helpers\Html;
use yii\widgets\Menu;

AppAsset::register($this);

?>
<?php $this->beginPage(); ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language; ?>" class="h-100">
<head>
    <meta charset="<?= Yii::$app->charset; ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags(); ?>
    <title><?= Html::encode($this->title); ?></title>
    <?php $this->head(); ?>
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody(); ?>

<nav class="sidebar-wrapper">
    <div class="sidebar-header">
        <?= Html::a(Yii::$app->name, Yii::$app->homeUrl, ['class' => 'sidebar-brand']); ?>
        <button type="button" class="btn btn-link sidebar-toggle"><i class="fa-solid fa-bars"></i></button>
    </div>
    <div class="sidebar-menu">
        <?= Menu::widget(['items' => \atom\cms\Module::getInstance()->getMenuItems()]); ?>
    </div>
    <div class="sidebar-user">
        <div class="user-image"><i class="fa-solid fa-user"></i></div>
        <div class="user-content">
            <div class="user-name"><?= Html::encode(Yii::$app->user->identity->displayName); ?></div>
            <div class="user-links">
                <?= Html::a('Settings', ['/cms/account/change-password']); ?>
                <?= Html::a('Logout', ['/cms/account/logout']); ?>
            </div>
        </div>
    </div>
</nav>

<main role="main" class="flex-shrink-0">
    <div class="container-fluid">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]); ?>
        <?= Alert::widget(); ?>
        <?= $content; ?>
    </div>
</main>

<?php $this->endBody(); ?>
</body>
</html>
<?php $this->endPage(); ?>
