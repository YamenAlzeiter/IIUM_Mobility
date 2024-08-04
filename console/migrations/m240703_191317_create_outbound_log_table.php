<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%outbound_log}}`.
 */
class m240703_191317_create_outbound_log_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%outbound_log}}', [
            'id' => $this->primaryKey(),
            'outbound_id' => $this->integer(),

            'old_status' => $this->integer(),
            'new_status' => $this->integer(),

            'message' => $this->text(),


            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultValue(null),

            'created_by' => $this->text(),
        ]);
        $this->addForeignKey(
            'fk-outlog',
            '{{outbound_log}}',
            'outbound_id',
            '{{outbound}}',
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
        $this->dropTable('{{%outbound_log}}');
    }
}
