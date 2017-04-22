<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "tel_msg".
 *
 * @property integer $id
 * @property string $tel
 * @property string $code
 * @property integer $times
 * @property string $date
 * @property integer $send_time
 */
class TelMsg extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tel_msg';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tel', 'code', 'date', 'send_time'], 'required'],
            [['tel','times'], 'integer'],
            [['code'], 'string', 'max' => 20],
            [['date'], 'string', 'max' => 30],
            [['send_time'], 'safe', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tel' => 'Tel',
            'code' => 'Code',
            'times' => 'Times',
            'date' => 'Date',
            'send_time' => 'Send Time',
        ];
    }
}
