<?php
namespace yii\easyii\modules\feedback\api;

use Yii;
use yii\easyii\modules\feedback\models\Feedback as FeedbackModel;
use yii\easyii\widgets\ReCaptcha;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/**
 * Feedback module API
 * @package yii\easyii\modules\feedback\api
 *
 * @method static string form(array $options = []) Returns fully worked standalone html form.
 * @method static array save(array $attributes) If you using your own form, this function will be useful for manual saving feedback's.
 */

class Feedback extends \yii\easyii\components\API
{
    const SENT_VAR = 'feedback_sent';

    private $_defaultFormOptions = [
        'errorUrl' => '',
        'successUrl' => '',
    ];

    public function api_form($options = [])
    {
        $model = new FeedbackModel;
        $settings = Yii::$app->getModule('admin')->activeModules['feedback']->settings;
        $options = array_merge($this->_defaultFormOptions, $options);

        ob_start();
        $form = ActiveForm::begin([
            'enableClientValidation' => true,
            'action' => Url::to(['/admin/feedback/send']),
        ]);

        echo Html::hiddenInput('errorUrl', $options['errorUrl'] ? $options['errorUrl'] : Url::current([self::SENT_VAR => 0]));
        echo Html::hiddenInput('successUrl', $options['successUrl'] ? $options['successUrl'] : Url::current([self::SENT_VAR => 1]));

        echo $form->field($model, 'name');
        echo $form->field($model, 'email')->input('email');

        if ($settings['enablePhone']) {
            echo $form->field($model, 'phone');
        }

        if ($settings['enableTitle']) {
            echo $form->field($model, 'title');
        }

        echo $form->field($model, 'text')->textarea();

        if ($settings['enableCaptcha']) {
            echo $form->field($model, 'reCaptcha')->widget(ReCaptcha::className());
        }

        echo <<<EOH
<div class="form-group">
    <input id="alksdfjjiwoqejlcmx" name="Feedback[charset]" type="hidden" value="">
    <div id="vaptchaContainer" style="width: 100%;height: 36px;">
        <div class="vaptcha-init-main">
            <div class="vaptcha-init-loading">
                <a href="/" target="_blank">
                    <img src="https://cdn.vaptcha.com/vaptcha-loading.gif" />
                </a>
                <span class="vaptcha-text">Vaptcha启动中...</span>
            </div>
        </div>
    </div>
</div>
EOH;

        echo Html::submitButton(Yii::t('easyii', 'Send'), ['class' => 'feedback-btn btn btn-primary', 'disabled' => 'disabled']);
        ActiveForm::end();

        return ob_get_clean();
    }

    public function api_save($data)
    {
        if ($data['charset'] == date('Y-m-d')) {
            $model = new FeedbackModel($data);
            if ($model->save()) {
                return ['result' => 'success'];
            } else {
                return ['result' => 'error', 'error' => $model->getErrors()];
            }
        } else {
            return ['result' => 'success'];
        }
    }
}
