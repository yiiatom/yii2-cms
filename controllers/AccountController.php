<?php

namespace atom\cms\controllers;

use Yii;
use atom\BackendController;
use atom\cms\forms\ChangePasswordForm;
use atom\cms\forms\LoginForm;
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
                        'roles' => ['Admin'],
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
        $isPasswordExpired = $model->getUser()->isPasswordExpired();
        if ($model->load(Yii::$app->request->post()) && $model->process()) {
            Yii::$app->session->setFlash('success', 'Password updated successfully.');
            return $isPasswordExpired ? $this->goBack() : $this->goHome();
        }

        return $this->render('change-password', [
            'model' => $model,
        ]);
    }
}
