<?php


namespace deadmantfa\yii2\zoho\components;


use deadmantfa\yii2\zoho\exceptions\GenerateTokenException;
use deadmantfa\yii2\zoho\models\ZohoAuth;
use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;
use yii\httpclient\Client;
use yii\httpclient\Exception;

class ZohoApiClient extends Component
{

    public $organizationId;
    public $apiBaseUrl;

    private $_httpClient;
    private $_token = null;

    public function init()
    {
        parent::init(); // TODO: Change the autogenerated stub
        $auth = ZohoAuth::find()->where(['source' => 'zoho'])->orderBy(['updated_at' => SORT_DESC])->one();
        if (!$auth) {
            throw new GenerateTokenException('You need to authorize a token');
        }

        $now = new \DateTime();
        $updatedAuth = new \DateTime($auth->updated_at);
        $updatedAuth->add(new \DateInterval('PT1H'));

        if ($now >= $updatedAuth) {
            $client = new Client([
                'baseUrl' => 'https://accounts.zoho.com/oauth/v2/'
            ]);
            try {
                $response = $client->post('token', [
                    'refresh_token' => $auth->refresh_token,
                    'client_id' => Yii::$app->params['zoho-api-client-id'],
                    'client_secret' => Yii::$app->params['zoho-api-client-secret'],
                    'grant_type' => 'refresh_token'
                ])->send();
                if (!$response->isOk) {
                    Yii::$app->getSession()->setFlash('error', [
                        Yii::t('app', $response->data['message']),
                    ]);
                    return false;
                }
                $auth->access_token = $response->data['access_token'];
                $auth->save();
                $auth->refresh();
            } catch (Exception $e) {
                Yii::$app->getSession()->setFlash('error', [
                    Yii::t('app', $response->data['message']),
                ]);
                return false;
            }
        }
        $this->_token = $auth->access_token;
    }

    public function getHttpClient()
    {
        if (!is_object($this->_httpClient)) {
            try {
                $this->_httpClient = Yii::createObject([
                    'class' => Client::class,
                    'baseUrl' => $this->apiBaseUrl,
                    'requestConfig' => [
                        'format' => Client::FORMAT_JSON,
                        'headers' => [
                            'Authorization' => 'Bearer ' . $this->_token
                        ]
                    ],
                    'responseConfig' => [
                        'format' => Client::FORMAT_JSON
                    ]
                ]);
            } catch (InvalidConfigException $e) {
                Yii::$app->getSession()->setFlash('error', [
                    Yii::t('app', 'Invalid Http Client Configuration'),
                ]);
            }
        }
        return $this->_httpClient;
    }

    public function get($path, array $data = null)
    {
        if (strpos($path, '?') !== false) {
            $path .= '&organization_id=' . $this->organizationId;
        } else {
            $path .= '?organization_id=' . $this->organizationId;
        }
        $response = $this->getHttpClient()->get($path, $data)->send();

        if (!$response->isOk) {
            Yii::$app->getSession()->setFlash('error', [
                Yii::t('app', $response->data['message']),
            ]);
            return false;
        }
        return $response->data;
    }

    public function post($path, array $data = null)
    {
        if (strpos($path, '?') !== false) {
            $path .= '&organization_id=' . $this->organizationId;
        } else {
            $path .= '?organization_id=' . $this->organizationId;
        }
        $response = $this->getHttpClient()->post($path, $data)->send();

        if (!$response->isOk) {
            Yii::$app->getSession()->setFlash('error', [
                Yii::t('app', $response->data['message']),
            ]);
            return false;
        }
        return $response->data;
    }

    public function put($path, array $data = null)
    {
        if (strpos($path, '?') !== false) {
            $path .= '&organization_id=' . $this->organizationId;
        } else {
            $path .= '?organization_id=' . $this->organizationId;
        }
        $response = $this->getHttpClient()->put($path, $data)->send();

        if (!$response->isOk) {
            Yii::$app->getSession()->setFlash('error', [
                Yii::t('app', $response->data['message']),
            ]);
            return false;
        }
        return $response->data;
    }

    public function delete($path, array $data = null)
    {
        if (strpos($path, '?') !== false) {
            $path .= '&organization_id=' . $this->organizationId;
        } else {
            $path .= '?organization_id=' . $this->organizationId;
        }
        $response = $this->getHttpClient()->delete($path, $data)->send();

        if (!$response->isOk) {
            Yii::$app->getSession()->setFlash('error', [
                Yii::t('app', $response->data['message']),
            ]);
            return false;
        }
        return $response->data;
    }
}
