<?php

namespace deadmantfa\yii2\zoho\controllers;

use yii\web\Controller;

/**
 * Default controller for the `YiiZohoModule` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}
