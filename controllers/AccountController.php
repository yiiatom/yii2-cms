<?php

namespace atom\cms\controllers;

use Yii;
use atom\BackendController;
use atom\cms\models\ChangePasswordForm;
use atom\cms\models\LoginForm;
use yii\filters\AccessControl;

class AccountController extends BackendController
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['login'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                ],
            ],
        ];
    }

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $this->layout = 'login';

        $model = new LoginForm;
        if ($model->load(Yii::$app->request->post()) && $model->process()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionChangePassword()
    {
        $model = new ChangePasswordForm;
        if ($model->load(Yii::$app->request->post()) && $model->process()) {
            Yii::$app->session->setFlash('success', 'Password updated successfully.');
            return $this->goHome();
        }

        return $this->render('change-password', [
            'model' => $model,
        ]);
    }
}
