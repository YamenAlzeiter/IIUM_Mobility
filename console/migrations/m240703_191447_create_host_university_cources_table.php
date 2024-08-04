<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%host_university_cources}}`.
 */
class m240703_191447_create_host_university_cources_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%host_university_cources}}', [
            'id' => $this->primaryKey(),
            'application_id' => $this->integer(),
            'course_id' => $this->string(),
            'course_name' => $this->string(),
            'course_credit_hours' => $this->double(),
        ]);
        $this->addForeignKey(
            'fk-application_id',
            '{{host_university_cources}}',
            'application_id',
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
        $this->dropTable('{{%host_university_cources}}');
    }
}
