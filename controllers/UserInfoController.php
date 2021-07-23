<?php

namespace app\controllers;

use app\models\UserInfo;
use app\helpers\BehaviorsFromParamsHelper;
use Yii;

class UserInfoController extends \yii\rest\ActiveController
{
    public $modelClass = 'app\models\UserInfo';

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
        $behaviors = BehaviorsFromParamsHelper::behaviors($behaviors);
        return $behaviors;
    }

    public function actionSet()
    {
        $params = Yii::$app->request->post();
        $model = UserInfo::findByUserId(Yii::$app->user->id);
        if (!$model) {
            $model = new UserInfo();
            $model->user_id = Yii::$app->user->id;
        }
        $model->setAttributes($params);
        if ($model->save()) {
            Yii::$app->response->statusCode = 201;
            return [
                'status' => 201,
                'message' => 'User info has been saved',
                'data' => UserInfo::findByUserId(Yii::$app->user->id),
            ];
        }
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