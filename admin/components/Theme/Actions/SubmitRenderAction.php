<?php

namespace admin\components\Theme\Actions;

use admin\components\Theme\Views\ViewContext;

class SubmitRenderAction extends \Brezgalov\ApiHelpers\v2\SubmitRenderAction
{
    /**
     * @var string
     */
    public $viewContext = ViewContext::class;
}