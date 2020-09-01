<?php


namespace deadmantfa\yii2\zoho\migrations;


class m200807_144637_zoho_auth_table extends \yii\db\Migration
{
    public function safeUp()
    {

        $this->createTable('zoho_auth', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'source' => $this->string()->notNull(),
            'access_token' => $this->string()->notNull(),
            'refresh_token' => $this->string()->notNull(),
            'expires_in' => $this->string()->notNull(),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
        ]);

        $this->addForeignKey('fk-zoho-auth-user_id-user-id', 'zoho_auth', 'user_id', 'user', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropTable('zoho_auth');
    }
}
