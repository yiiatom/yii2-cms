<?php

use atom\cms\assets\AppAsset;
use atom\cms\widgets\Alert;
use yii\helpers\Html;

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
<body class="d-flex flex-column h-100 page-login">
<?php $this->beginBody(); ?>

<main role="main" class="flex-shrink-0">
    <div class="container">
        <div class="login-form-wrapper">
            <?= Alert::widget(); ?>
            <?= $content; ?>
        </div>
    </div>
</main>

<?php $this->endBody(); ?>
</body>
</html>
<?php $this->endPage(); ?>
