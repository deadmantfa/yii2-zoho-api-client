<?php

namespace deadmantfa\yii2\zoho\controllers;

use deadmantfa\yii2\zoho\auth\ZohoAuthHandler;
use deadmantfa\yii2\zoho\models\ZohoAuth;
use yii\authclient\AuthAction;
use yii\web\Controller;

/**
 * Default controller for the `YiiZohoModule` module
 */
class DefaultController extends Controller
{

    public function actions()
    {
        return [
            'auth' => [
                'class' => AuthAction::class,
                'successCallback' => [$this, 'onAuthSuccess'],
            ],
        ];
    }

    public function onAuthSuccess($client)
    {
        (new ZohoAuthHandler($client))->handle();
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $model = ZohoAuth::find()->where(['user_id' => \Yii::$app->user->id, 'source' => 'zoho'])->one();
        return $this->render('index', ['model' => $model]);
    }
}
