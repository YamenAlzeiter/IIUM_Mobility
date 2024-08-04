<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%pic}}`.
 */
class m240703_190300_create_pic_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%pic}}', [
            'id' => $this->primaryKey(),
            'kcdio_id' => $this->string(),
            'name' => $this->string(),
            'email' => $this->string(),
            'name_cc_x' => $this->string(),
            'email_cc_x' => $this->string(),
            'name_cc_xx' => $this->string(),
            'email_cc_xx' => $this->string(),
        ]);
        $this->addForeignKey(
            'fk-kcdio',
            '{{pic}}',
            'kcdio_id',
            '{{kcdio}}',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%pic}}');
    }
}
