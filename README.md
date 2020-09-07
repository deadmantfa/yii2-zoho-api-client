Yii2 Zoho REST API Client
====================
A Client for Zoho RESTful API's

[![Powered By Yii2](https://img.shields.io/static/v1?label=Powered&nbsp;By&message=Yii2&color=blue&style=for-the-badge)](https://yiiframework.com/)
[![Type](https://img.shields.io/static/v1?label=Type&message=Yii2&nbsp;Extension&color=yellow&style=for-the-badge)](https://yiiframework.com/)

![Packagist Version](https://img.shields.io/packagist/v/deadmantfa/yii2-zoho-api-client?style=for-the-badge)
![GitHub](https://img.shields.io/github/license/deadmantfa/yii2-zoho-api-client?style=for-the-badge)
![Packagist Stars](https://img.shields.io/packagist/stars/deadmantfa/yii2-zoho-api-client?style=for-the-badge)
![GitHub top language](https://img.shields.io/github/languages/top/deadmantfa/yii2-zoho-api-client?style=for-the-badge)
![Packagist Downloads](https://img.shields.io/packagist/dt/deadmantfa/yii2-zoho-api-client?style=for-the-badge)
![GitHub stars](https://img.shields.io/github/stars/deadmantfa/yii2-zoho-api-client?style=for-the-badge)
![GitHub last commit](https://img.shields.io/github/last-commit/deadmantfa/yii2-zoho-api-client?style=for-the-badge)
[![Maintenance](https://img.shields.io/badge/Maintained%3F-yes-green.svg?style=for-the-badge)](https://GitHub.com/deadmantfa/yii2-zoho-api-client/graphs/commit-activity)
[![saythanks](https://img.shields.io/badge/say-thanks-ff69b4.svg?style=for-the-badge)](https://saythanks.io/to/wenceslausdsilva%40gmail.com)

![forthebadge](https://forthebadge.com/images/badges/you-didnt-ask-for-this.svg)

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
