<?php

namespace deadmantfa\yii2\zoho;

use yii\base\Module as BaseModule;

/**
 * YiiZohoModule module definition class
 */
class Module extends BaseModule
{
    public $baseApiURI = 'https://inventory.zoho.in/';

    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'deadmantfa\yii2\zoho\controllers';

    public $defaultRoute = 'default/index';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
