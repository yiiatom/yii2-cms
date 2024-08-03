<?php

namespace atom\cms\controllers;

use Yii;
use atom\BackendController;
use atom\cms\models\User;
use atom\cms\models\UserForm;
use atom\cms\models\UserPasswordForm;
use yii\web\BadRequestHttpException;

class UserController extends BackendController
{
    public function actionIndex()
    {
        $model = new User;
        return $this->render('index', [
            'model' => $model,
        ]);
    }

    public function actionCreate()
    {
        $model = new UserForm(new User);
        if ($model->load(Yii::$app->getRequest()->post()) && $model->process()) {
            Yii::$app->session->setFlash('success', 'Changes saved successfully.');
            return $this->redirect(['index']);
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $user = User::find()->where(['and',
            ['id' => $id],
            ['<>', 'username', 'admin'],
        ])->one();
        if (!$user) {
            throw new BadRequestHttpException('User not found.');
        }
        $model = new UserForm($user);
        if ($model->load(Yii::$app->getRequest()->post()) && $model->process()) {
            Yii::$app->session->setFlash('success', 'Changes saved successfully.');
            return $this->redirect(['index']);
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionPassword($id)
    {
        $user = User::find()->where(['and',
            ['id' => $id],
            ['<>', 'username', 'admin'],
        ])->one();
        if (!$user) {
            throw new BadRequestHttpException('User not found.');
        }
        $model = new UserPasswordForm($user);
        if ($model->load(Yii::$app->getRequest()->post()) && $model->process()) {
            Yii::$app->session->setFlash('success', 'Changes saved successfully.');
            return $this->redirect(['index']);
        }
        return $this->render('password', [
            'model' => $model,
        ]);
    }
}
