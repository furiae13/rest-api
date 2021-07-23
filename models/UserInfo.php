<?php

namespace app\models;

class UserInfo extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'user_info';
    }

    public function rules()
    {
        return [
            [['first_name','last_name', 'phone_number'], 'required'],
            [['first_name', 'last_name', 'phone_number'], 'string', 'max' => 255]
        ];
    }

    /**
     * Finds user info by user_id
     *
     * @param integer $user_id
     * @return static|null
     */
    public static function findByUserId($user_id)
    {
        return static::findOne(['user_id' => $user_id]);
    }
}