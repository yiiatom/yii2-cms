<?php

namespace atom\cms\controllers;

use Yii;
use atom\BackendController;
use atom\cms\forms\MediaLibraryForm;
use yii\helpers\Html;
use yii\web\BadRequestHttpException;
use yii\web\UploadedFile;

class MediaLibraryController extends BackendController
{
    public function actionIndex()
    {
        $model = new MediaLibraryForm;
        if (Yii::$app->request->isPost) {
            $model->file = UploadedFile::getInstance($model, 'file');
            if ($model->process()) {
                Yii::$app->session->setFlash('success', 'File uploaded successfully.');
            }
            return $this->refresh();
        }
        return $this->render('index', [
            'model' => $model,
            'files' => $this->getFiles(),
        ]);
    }

    public function actionDelete($name)
    {
        $file = realpath(Yii::getAlias('@webroot/public/') . $name);
        if (!in_array($file, $this->getFiles())) {
            $file = false;
        }
        if (!$file) {
            throw new BadRequestHttpException('File not found.');
        }
        if (@unlink($file)) {
            Yii::$app->session->setFlash('success', 'File deleted successfully.');
        } else {
            Yii::$app->session->setFlash('danger', 'Unable to delete file "' . Html::encode($name) . '".');
        }
        return $this->redirect(['index']);
    }

    private function getFiles(): array
    {
        $files = glob(Yii::getAlias('@webroot/public/*'), GLOB_NOSORT);
        usort($files, fn ($a, $b) => filemtime($b) - filemtime($a));
        return $files;
    }
}
