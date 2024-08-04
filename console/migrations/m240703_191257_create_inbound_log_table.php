<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%inbound_log}}`.
 */
class m240703_191257_create_inbound_log_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%inbound_log}}', [
            'id' => $this->primaryKey(),
            'inbound_id' => $this->integer(),

            'old_status' => $this->integer(),
            'new_status' => $this->integer(),

            'message' => $this->text(),


            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultValue(null),

            'created_by' => $this->text(),
        ]);
        $this->addForeignKey(
            'fk-inlog',
            '{{inbound_log}}',
            'inbound_id',
            '{{inbound}}',
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
        $this->dropTable('{{%inbound_log}}');
    }
}
