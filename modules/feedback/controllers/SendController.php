<?php
namespace yii\easyii\modules\feedback\controllers;

use Yii;
use yii\easyii\modules\feedback\models\Feedback as FeedbackModel;

class SendController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $model = new FeedbackModel;

        $request = Yii::$app->request;

        $post = $request->post();

        if ($model->load($request->post()) && $post['Feedback']['charset'] == date('Y-m-d')) {
            $returnUrl = $model->save() ? $request->post('successUrl') : $request->post('errorUrl');
            return $this->redirect($returnUrl);
        } else {
            return $this->redirect(Yii::$app->request->baseUrl);
        }
    }
}
