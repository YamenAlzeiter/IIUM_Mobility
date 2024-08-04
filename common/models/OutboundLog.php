<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "outbound_log".
 *
 * @property int $id
 * @property int|null $outbound_id
 * @property int|null $old_status
 * @property int|null $new_status
 * @property string|null $message
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property string|null $created_by
 *
 * @property Inbound $outbound
 */
class OutboundLog extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'outbound_log';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['outbound_id', 'old_status', 'new_status'], 'default', 'value' => null],
            [['outbound_id', 'old_status', 'new_status'], 'integer'],
            [['message', 'created_by'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['outbound_id'], 'exist', 'skipOnError' => true, 'targetClass' => Inbound::class, 'targetAttribute' => ['outbound_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'outbound_id' => 'outbound ID',
            'old_status' => 'Old Status',
            'new_status' => 'New Status',
            'message' => 'Message',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
        ];
    }

    /**
     * Gets query for [[outbound]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOutbound()
    {
        return $this->hasOne(Inbound::class, ['id' => 'outbound_id']);
    }
}
