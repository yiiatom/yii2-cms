<?php

namespace atom\cms;

use Yii;
use yii\helpers\Html;
use yii\web\ForbiddenHttpException;

class Module extends \yii\base\Module
{
    public $defaultRoute = 'default/index';

    public $layout = 'main';

    public function init()
    {
        parent::init();

        // Check console
        $isConsole = Yii::$app instanceof \yii\console\Application;

        // Modules
        // $modules = [];
        // foreach (glob(Yii::getAlias('@app/modules') . '/*') as $dir) {
        //     if (file_exists("{$dir}/BackendModule.php")) {
        //         $name = basename($dir);
        //         $module = ['class' => "app\\modules\\{$name}\\BackendModule"];
        //         if ($isConsole) {
        //             $module['controllerNamespace'] = "app\\modules\\{$name}\\commands";
        //         }
        //         $modules[$name] = $module;
        //     }
        // }
        // $this->modules = $modules;

        // Application
        if (!$isConsole) {
            $this->initApplication();
            $this->checkPasswordExpired();
        }
    }

    private function initApplication(): void
    {
        Yii::$app->name = 'Atom';
        Yii::$app->homeUrl = ["/{$this->id}/default/index"];
        Yii::$app->errorHandler->errorAction = "/{$this->id}/default/error";
        Yii::$app->getUser()->loginUrl = ["/{$this->id}/account/login"];
    }

    private function checkPasswordExpired(): void
    {
        $user = Yii::$app->getUser();

        // Skip some routes
        $routes = [
            "/{$this->id}/account/login",
            "/{$this->id}/account/logout",
            "/{$this->id}/account/change-password",
        ];
        if (in_array('/' . Yii::$app->requestedRoute, $routes)) {
            return;
        }

        // Check
        if ($user->getIdentity()->isPasswordExpired()) {
            $request = Yii::$app->getRequest();

            $canRedirect = $user->checkRedirectAcceptable();

            // Return URL
            if ($user->enableSession
                && $request->getIsGet()
                && (!$request->getIsAjax())
                && $canRedirect
            ) {
                $user->setReturnUrl($request->getUrl());
            }

            // Redirect
            if ($canRedirect) {
                Yii::$app->getSession()->setFlash('warning', 'Your password has been expired.');
                Yii::$app->getResponse()->redirect(["/{$this->id}/account/change-password"]);
                Yii::$app->end();
            }

            throw new ForbiddenHttpException('Your password has been expired.');
        }
    }

    public function getMenuItems()
    {
        $items = [
            [
                'icon' => '<i class="menu-icon fa-solid fa-gauge-high"></i>',
                'label' => 'Dashboard',
                'url' => ["/{$this->id}/default/index"],
            ],
            [
                'icon' => '<i class="menu-icon fa-solid fa-user"></i>',
                'label' => 'Users',
                'url' => ["/{$this->id}/user/index"],
            ],
            [
                'icon' => '<i class="menu-icon fa-solid fa-envelope"></i>',
                'label' => 'Notifications',
                'url' => ["/{$this->id}/notification/index"],
            ],
            // [
            //     'icon' => '<i class="menu-icon fa-solid fa-images"></i>',
            //     'label' => 'Media library',
            //     'url' => '#',
            // ],
            // [
            //     'icon' => '<i class="menu-icon fa-solid fa-puzzle-piece"></i>',
            //     'label' => 'Modules',
            //     'url' => '#',
            // ],
            // [
            //     'icon' => '<i class="menu-icon fa-solid fa-cart-shopping"></i>',
            //     'label' => 'E-commerce',
            //     'badge' => '3',
            //     'items' => [
            //         ['label' => 'Products', 'url' => '#'],
            //         ['label' => 'Cities', 'url' => '#'],
            //         ['label' => 'Stores', 'url' => '#'],
            //     ],
            // ],
        ];

        foreach ($this->modules as $id => $config) {
            if ($module = $this->getModule($id)) {
                $module->menu($items, "/{$this->id}/{$id}");
            }
        }

        $menuItems = [];
        foreach ($items as $item) {
            $menuItem = [
                'encode' => false,
                'label' => $item['icon'] ?? '<i class="menu-icon"></i>',
                'url' => $item['url'] ?? '#',
            ];
            if (isset($item['label'])) {
                $menuItem['label'] .= Html::tag('span', $item['label']);
            }
            if (isset($item['badge'])) {
                $menuItem['label'] .= ' ' . Html::tag('span', $item['badge'], ['class' => 'badge badge-pill badge-primary']);
            }
            if (isset($item['items'])) {
                $menuItem['items'] = $item['items'];
                $menuItem['options'] = ['class' => 'sidebar-dropdown'];
            }
            $menuItems[] = $menuItem;
        }

        return $menuItems;
    }
}
