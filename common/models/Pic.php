<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "pic".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $email
 * @property string|null $name_cc_x
 * @property string|null $email_cc_x
 * @property string|null $name_cc_xx
 * @property string|null $email_cc_xx
 * @property int $kcdio_id
 * @property Inbound[] $inbounds
 * @property Inbound[] $inbounds0
 * @property Outbound[] $outbounds
 * @property Outbound[] $outbounds0
 */
class Pic extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pic';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // Ensure 'name' and 'email' are required and of type string
            [['name', 'email', 'name_cc_x', 'email_cc_x', 'name_cc_xx', 'email_cc_xx'], 'string', 'max' => 255],
            [['name', 'email'], 'required'], // Make 'name' and 'email' required
            [['email', 'email_cc_x', 'email_cc_xx'], 'email'], // Ensure valid email format
            ['kcdio_id', 'required'], // Make 'kcdio_id' required
            ['kcdio_id', 'integer'], // Ensure 'kcdio_id' is an integer
        ];
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'kcdio_id' => 'KCDIO',
            'name' => 'Name',
            'email' => 'Email',
            'name_cc_x' => 'Additional PIC Name',
            'email_cc_x' => 'Additional PIC Email',
            'name_cc_xx' => 'Additional PIC Name',
            'email_cc-xx' => 'Additional PIC Email',
        ];
    }

    /**
     * Gets query for [[Inbounds]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getInbounds()
    {
        return $this->hasMany(Inbound::class, ['kulliyyah_id' => 'id']);
    }

    /**
     * Gets query for [[Inbounds0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getInbounds0()
    {
        return $this->hasMany(Inbound::class, ['cps_id' => 'id']);
    }

    /**
     * Gets query for [[Outbounds]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOutbounds()
    {
        return $this->hasMany(Outbound::class, ['dean_id' => 'id']);
    }

    /**
     * Gets query for [[Outbounds0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOutbounds0()
    {
        return $this->hasMany(Outbound::class, ['hod_id' => 'id']);
    }

}
