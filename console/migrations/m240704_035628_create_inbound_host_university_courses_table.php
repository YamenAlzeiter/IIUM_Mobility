<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%inbound_host_university_courses}}`.
 */
class m240704_035628_create_inbound_host_university_courses_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%inbound_host_university_courses}}', [
            'id' => $this->primaryKey(),
            'application_id' => $this->integer(),
            'course_id' => $this->string(20),
            'course_name' => $this->string(100),
            'course_credit_hours' => $this->double(),
        ]);
        $this->addForeignKey(
            'fk-application_id',
            '{{inbound_host_university_courses}}',
            'application_id',
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
        $this->dropTable('{{%inbound_host_university_courses}}');
    }
}
