<?php

namespace admin\components\Theme\Views;

use yii\base\ViewContextInterface;

class ViewContext implements ViewContextInterface
{
    /**
     * @return string
     */
    public function getViewPath()
    {
        return __DIR__;
    }
}