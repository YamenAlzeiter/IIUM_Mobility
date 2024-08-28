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
            'kcdio_id' => $this->integer(),
            'name' => $this->string(100),
            'email' => $this->string(50),
            'name_cc_x' => $this->string(100),
            'email_cc_x' => $this->string(50),
            'name_cc_xx' => $this->string(100),
            'email_cc_xx' => $this->string(50),
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
