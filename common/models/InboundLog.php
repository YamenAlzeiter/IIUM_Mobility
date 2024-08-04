<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "inbound_log".
 *
 * @property int $id
 * @property int|null $inbound_id
 * @property int|null $old_status
 * @property int|null $new_status
 * @property string|null $message
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property string|null $created_by
 *
 * @property Inbound $inbound
 */
class InboundLog extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'inbound_log';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['inbound_id', 'old_status', 'new_status'], 'default', 'value' => null],
            [['inbound_id', 'old_status', 'new_status'], 'integer'],
            [['message', 'created_by'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['inbound_id'], 'exist', 'skipOnError' => true, 'targetClass' => Inbound::class, 'targetAttribute' => ['inbound_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'inbound_id' => 'Inbound ID',
            'old_status' => 'Old Status',
            'new_status' => 'New Status',
            'message' => 'Message',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
        ];
    }

    /**
     * Gets query for [[Inbound]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getInbound()
    {
        return $this->hasOne(Inbound::class, ['id' => 'inbound_id']);
    }
}
