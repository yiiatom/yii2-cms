<?php

namespace atom\cms\filters;

use atom\base\Filter;
use atom\cms\models\Notification;
use yii\data\DataProviderInterface;
use yii\data\ActiveDataProvider;

class NotificationFilter extends Filter
{
    public function getDataProvider(array $config = []): DataProviderInterface
    {
        if (!isset($config['query'])) {
            $config['query'] = Notification::find();
        }
        return new ActiveDataProvider($config);
    }
}
