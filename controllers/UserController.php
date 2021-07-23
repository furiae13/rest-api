<?php

namespace app\controllers;

use app\models\User;
use Yii;


class UserController extends \yii\rest\ActiveController
{
    public $modelClass = 'app\models\User';

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::className(),
            'cors' => [
                'Origin' => ['*'],
                'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'DELETE', 'OPTIONS'],
                'Access-Control-Request-Headers' => ['*'],
            ],
        ];
        $behaviors['contentNegotiator'] = [
            'class' => \yii\filters\ContentNegotiator::className(),
            'formats' => [
                'application/json' => \yii\web\Response::FORMAT_JSON,
            ],
        ];

        return $behaviors;
    }

    public function actionSignup()
    {
        $model = new User();
        $params = Yii::$app->request->post();
        if(!$params) {
            Yii::$app->response->statusCode = 400;
            return [
                'status' => 400,
                'message' => "Email or/and password is empty.",
                'data' => ''
            ];
        }

        $model->email = $params['email'];
        $model->setPassword($params['password']);
        $model->generateAuthKey();
        $model->status = User::STATUS_ACTIVE;

        if ($model->save()) {
            Yii::$app->response->statusCode = 201;
            return [
                'status' => 201,
                'message' => 'User has been registered',
                'data' => User::findByEmail($model->email),
            ];
        } else {
            Yii::$app->response->statusCode = 400;
            $model->getErrors();
            return [
                'status' => 400,
                'message' => 'Error!',
                'data' => [
                    'hasErrors' => $model->hasErrors(),
                    'getErrors' => $model->getErrors(),
                ]
            ];
        }
    }

    public function actionLogin()
    {
        $params = Yii::$app->request->post();
        if(empty($params['email']) || empty($params['password'])) return [
            'status' => 400,
            'message' => "Email or/and password is empty.",
            'data' => ''
        ];

        $user = User::findByEmail($params['email']);

        if ($user->validatePassword($params['password'])) {
            Yii::$app->response->statusCode = 302;
            $user->generateAuthKey();
            $user->save();
            return [
                'status' => 302,
                'message' => 'You are successfully logged in',
                'data' => [
                    'id' => $user->email,
                    'token' => $user->auth_key,
                    'email' => $user['email'],
                ]
            ];
        } else {
            Yii::$app->response->statusCode = 401;
            return [
                'status' => 401,
                'message' => 'The email address or password you entered is incorrect',
                'data' => ''
            ];
        }
    }
}
