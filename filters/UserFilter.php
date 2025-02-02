<?php

namespace atom\cms\filters;

use atom\base\Filter;
use atom\cms\models\User;
use yii\data\DataProviderInterface;
use yii\data\ActiveDataProvider;

class UserFilter extends Filter
{
    public $hideAdmin = true;

    public function getDataProvider(array $config = []): DataProviderInterface
    {
        if (!isset($config['query'])) {
            $config['query'] = User::find();
        }
        if ($this->hideAdmin) {
            $config['query']->andWhere(['<>', 'username', 'admin']);
        }
        return new ActiveDataProvider($config);
    }
}
