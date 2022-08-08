<?php

namespace admin\components\Theme\Actions;

use admin\components\Theme\Views\ViewContext;

class RenderAction extends \Brezgalov\ApiHelpers\v2\RenderAction
{
    /**
     * @var string
     */
    public $viewContext = ViewContext::class;
}