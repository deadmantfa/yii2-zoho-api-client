<?php

use yii\authclient\widgets\AuthChoice;
use yii\widgets\DetailView;

$this->title = 'Zoho Module';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php
echo DetailView::widget([
    'model' => $model,
    'attributes' => [
        'user.email',               // title attribute (in plain text)
        'source',
        'access_token',
        'refresh_token',
        'expires_in',
        'created_at:datetime', // creation date formatted as datetime
        'updated_at:datetime', // creation date formatted as datetime
    ],
]);
?>
<?php
$authAuthChoice = AuthChoice::begin([
    'baseAuthUrl' => ['/zoho/default/auth'],
    'popupMode' => false
]);
?>
<ul class="auth-clients">
    <?php foreach ($authAuthChoice->getClients() as $client): ?>

        <li><?= $authAuthChoice->clientLink($client, '<span class="fas fa-sign-in-alt fa-2x text-secondary">&nbsp;Re-Authorize Zoho</span>',
                [
                    'class' => 'auth-link',
                ]) ?></li>
    <?php endforeach; ?>
</ul>
