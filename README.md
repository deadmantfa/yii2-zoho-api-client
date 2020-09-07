Yii2 Zoho API Client
====================
A Client for Zoho API's

![Packagist Version](https://img.shields.io/packagist/v/deadmantfa/yii2-zoho-api-client?style=for-the-badge)
![GitHub](https://img.shields.io/github/license/deadmantfa/yii2-zoho-api-client?style=for-the-badge)
![Packagist Stars](https://img.shields.io/packagist/stars/deadmantfa/yii2-zoho-api-client?style=for-the-badge)
![GitHub top language](https://img.shields.io/github/languages/top/deadmantfa/yii2-zoho-api-client?style=for-the-badge)
![Packagist Downloads](https://img.shields.io/packagist/dt/deadmantfa/yii2-zoho-api-client?style=for-the-badge)
![GitHub stars](https://img.shields.io/github/stars/deadmantfa/yii2-zoho-api-client?style=for-the-badge)

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist deadmantfa/yii2-zoho-api-client "^v1.0.x"
```

or add

```
"deadmantfa/yii2-zoho-api-client": "^v1.0.x"
```

to the require section of your `composer.json` file.


Configuration
-----

Once the extension is installed, add it to your configuration  :

Please note the redirect url for OAUTH2 to work properly, please add it to your client on Zoho before continuing further.
Replace ``<YOUR_DOMAIN_NAME>`` with an actual domain or localhost

`<YOUR_DOMAIN_NAME>/zoho/default/auth?authclient=zoho`


In your `params.php` or `params-local.php` define the following
```php
    'zoho-api-client-id' => '<ZOHO_API_CLIENT_ID>',
    'zoho-api-client-secret' => '<ZOHO_API_CLIENT_SECRET>',
    'zoho-organization-id' => '<ZOHO_ORGANIZATION_ID>',
    'zoho-redirect-uri' => '<YOUR_DOMAIN_NAME>/zoho/default/auth?authclient=zoho'
```

Add the following in one of these file

`app/common/config/main.php` or `app/backend/config/main.php`
```php
    'modules' => [
        'zoho' => [
            'class' => \deadmantfa\yii2\zoho\Module::class,
        ],
    ],
    'components' => [
        'authClientCollection' => [
            'class' => \yii\authclient\Collection::class,
            'clients' => [
                'zoho' => [
                    'class' => \deadmantfa\yii2\zoho\auth\ZohoAuthClient::class,
                    'clientId' => $params['zoho-api-client-id'],
                    'clientSecret' => $params['zoho-api-client-secret'],
                    'returnUrl' => $params['zoho-redirect-uri'],
                ],
            ],
        ],
        'zoho'=> [
            'class' => \deadmantfa\yii2\zoho\components\ZohoApiClient::class,
            'apiBaseUrl'=>'https://inventory.zoho.com/api/v1/',
            'organizationId'=>$params['zoho-organization-id']
        ]
    ];  
```
For Migration add the following to

`app/console/config/main.php`

```php

use yii\console\controllers\MigrateController;

    'controllerMap' => [
        'migrate' => [
            'class' => MigrateController::class,
            'migrationPath' => [
                '@app/migrations',
                '@yii/rbac/migrations', // Just in case you forgot to run it on console (see next note)
            ],
            'migrationNamespaces' => [
                'deadmantfa\yii2\zoho\migrations',
            ],
        ],
    ],
```

Then run the following command

```shell script
./yii migrate
```

Usage
-----

To use the zoho api we need to first authorize and generate access_token and refresh_token

(http://<YOUR_DOMAIN_NAME>/zoho)

Follow the screenshots below

![Step 1](screenshots/1.png?raw=true)

![Step 2](screenshots/2.png?raw=true)

![Step 3](screenshots/3.png?raw=true)

After generating the access token and refresh token you can now call any api which is provided by Zoho

```php
Yii::$app->zoho->get('items', []);
Yii::$app->zoho->post('items', []);
Yii::$app->zoho->put('items', []);
Yii::$app->zoho->delete('items', []);
```
[Zoho Rest API Documentation](https://www.zoho.com/developer/rest-api.html)


Dependencies
------------
* [Yii2 Framework](https://www.yiiframework.com/)

* [Yii2 Auth Client](https://github.com/yiisoft/yii2-authclient)

* [Yii2 Http CLient](https://github.com/yiisoft/yii2-httpclient)
