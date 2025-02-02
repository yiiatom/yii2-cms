<?php

namespace atom\cms\controllers;

use atom\BackendController;
use atom\cms\filters\NotificationFilter;

class NotificationController extends BackendController
{
    public function actionIndex()
    {
        $filter = new NotificationFilter;
        return $this->render('index', [
            'filter' => $filter,
        ]);
    }
}
