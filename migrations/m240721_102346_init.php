<?php

use yii\db\Migration;

/**
 * Class m240721_102346_initial
 */
class m240721_102346_init extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // Users
        $this->createTable('user', [
            'id' => $this->primaryKey(),
            'username' => $this->string(20)->notNull(),
            'active' => $this->boolean()->notNull()->defaultValue(1),
            'email' => $this->string(200)->defaultValue(null),
            'password' => $this->string(64)->defaultValue(null),
            'passwordExpireAt' => $this->dateTime()->defaultValue(null),
            'accessToken' => $this->string(64)->defaultValue(null),
            'authKey' => $this->string(64)->defaultValue(null),
            'lastName' => $this->string(100)->defaultValue(null),
            'firstName' => $this->string(100)->defaultValue(null),
            'createdAt' => $this->dateTime()->defaultValue(null),
            'modifiedAt' => $this->dateTime()->defaultValue(null),
        ]);
        $this->createIndex(
            'idx-user-username',
            'user',
            'username',
            true,
        );
        $this->insert('user', [
            'username' => 'admin',
            'password' => Yii::$app->security->generatePasswordHash('admin'),
            'passwordExpireAt' => gmdate('Y-m-d H:i:s'),
            'lastName' => 'Admin',
        ]);
        $id = Yii::$app->db->getLastInsertID();
        $auth = Yii::$app->authManager;
        $role = $auth->createRole('Admin');
        $auth->add($role);
        $auth->assign($role, $id);

        // Notifications
        $this->createTable('notification', [
            'id' => $this->primaryKey(),
            'type' => $this->string(20)->defaultValue(null),
            'title' => $this->string(200)->notNull(),
            'content' => $this->text(),
            'createdAt' => $this->dateTime()->defaultValue(null),
        ]);

        // Settings
        $this->createTable('settings', [
            'id' => $this->primaryKey(),
            'name' => $this->string(200)->notNull(),
            'value' => $this->text(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // Settings
        $this->dropTable('settings');

        // Notifications
        $this->dropTable('notification');

        // Users
        $this->dropIndex(
            'idx-user-username',
            'user',
        );
        $this->dropTable('user');
        $auth = Yii::$app->authManager;
        $role = $auth->getRole('Admin');
        $auth->remove($role);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240721_102346_initial cannot be reverted.\n";

        return false;
    }
    */
}
