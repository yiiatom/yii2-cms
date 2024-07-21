<?php

namespace atom\cms\controllers;

use atom\BackendController;
use atom\cms\models\Notification;

class NotificationController extends BackendController
{
    public function actionIndex()
    {
        $model = new Notification;
        return $this->render('index', [
            'model' => $model,
        ]);
    }
}
