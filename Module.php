<?php

namespace atom\cms;

use Yii;
use yii\helpers\Html;

class Module extends \yii\base\Module
{
    public $defaultRoute = 'default/index';

    public $layout = 'main';

    public function init()
    {
        parent::init();

        // Check console
        $is_console = Yii::$app instanceof \yii\console\Application;

        // Modules
        var_dump($this->modules); die();
        $modules = [];
        foreach (glob(Yii::getAlias('@app/modules') . '/*') as $dir) {
            if (file_exists("{$dir}/BackendModule.php")) {
                $name = basename($dir);
                $module = ['class' => "app\\modules\\{$name}\\BackendModule"];
                if ($is_console) {
                    $module['controllerNamespace'] = "app\\modules\\{$name}\\commands";
                }
                $modules[$name] = $module;
            }
        }
        $this->modules = $modules;

        // Application
        if (!$is_console) {
            Yii::$app->name = 'Atom';
            Yii::$app->homeUrl = ['/cms/default/index'];
            Yii::$app->errorHandler->errorAction = '/cms/default/error';
            Yii::$app->user->loginUrl = ['/cms/account/login'];
        }
    }

    public function getMenuItems()
    {
        $items = [
            [
                'icon' => '<i class="menu-icon fa-solid fa-gauge-high"></i>',
                'label' => 'Dashboard',
                'url' => ['/cms/default/index'],
            ],
            [
                'icon' => '<i class="menu-icon fa-solid fa-envelope"></i>',
                'label' => 'Notifications',
                'url' => ['/cms/notification/index'],
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
                $module->menu($items, "/cms/{$id}");
            }
        }

        $menuItems = [];
        foreach ($items as $item) {
            $menuItem = [
                'encode' => false,
                'label' => isset($item['icon']) ? $item['icon'] : '<i class="menu-icon"></i>',
                'url' => isset($item['url']) ? $item['url'] : '#',
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
