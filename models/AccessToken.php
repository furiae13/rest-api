<?php

namespace app\models;

use yii\base\BaseObject;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

class AccessToken extends ActiveRecord
{
    public $tokenExpiration = 60 * 24 * 365; // in seconds
    public $defaultAccessGiven = '{"access":["all"]}';
    public $defaultConsumer = 'mobile';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'access_token';
    }

    /**
     * Generate new access_token that will be used at Authorization
     *
     * @param object $user the User Object (User::findOne($id))
     * @return nothing
     */
    public static function generateAuthKey($user)
    {
        $accessToken = new AccessToken();
        $accessToken->user_id = $user->id;
        $accessToken->consumer = $user->consumer ?? $accessToken->defaultConsumer;
        $accessToken->access_given = $user->access_given ?? $accessToken->defaultAccessGiven;
        $accessToken->token = $user->authKey;
        $accessToken->used_at = strtotime("now");
        $accessToken->expire_at = $accessToken->tokenExpiration + $accessToken->used_at;
        $accessToken->save();
    }
}
