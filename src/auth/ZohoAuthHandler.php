<?php

namespace deadmantfa\yii2\zoho\auth;

use deadmantfa\yii2\zoho\models\ZohoAuth;
use Yii;
use yii\authclient\ClientInterface;
use yii\helpers\ArrayHelper;

class ZohoAuthHandler
{
    /**
     * @var ClientInterface
     */
    private $client;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    public function handle()
    {
        $attributes = $this->client->getUserAttributes();
        $access_token = ArrayHelper::getValue($attributes, 'access_token');
        $refresh_token = ArrayHelper::getValue($attributes, 'refresh_token');
        $expires_in = ArrayHelper::getValue($attributes, 'expires_in');
        /* @var Auth $auth */
        $auth = ZohoAuth::find()->where(['user_id' => Yii::$app->user->id, 'source' => $this->client->getId()])->one();
        if (!$auth) {
            $auth = new ZohoAuth([
                'user_id' => Yii::$app->user->id,
                'source' => $this->client->getId(),
                'access_token' => $access_token,
                'refresh_token' => $refresh_token,
                'expires_in' => $expires_in,
            ]);
        }
        if ($auth->save()) {
            Yii::$app->getSession()->setFlash('success', [
                Yii::t('app', 'Linked {client} account.', [
                    'client' => $this->client->getTitle()
                ]),
            ]);
        } else {
            Yii::$app->getSession()->setFlash('error', [
                Yii::t('app', 'Unable to link {client} account: {errors}', [
                    'client' => $this->client->getTitle(),
                    'errors' => json_encode($auth->getErrors()),
                ]),
            ]);
        }

        return Yii::$app->response->redirect(['/zoho']);
    }

}
