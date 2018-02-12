<?php
namespace yii\easyii\modules\feedback;

class FeedbackModule extends \yii\easyii\components\Module
{
    public $settings = [
        'mailAdminOnNewFeedback' => true,
        'subjectOnNewFeedback' => '新的客户反馈消息',
        'templateOnNewFeedback' => '@easyii/modules/feedback/mail/en/new_feedback',

        'answerTemplate' => '@easyii/modules/feedback/mail/en/answer',
        'answerSubject' => '回复你的客户反馈消息',
        'answerHeader' => '您好,',
        'answerFooter' => '此致.',

        'enableTitle' => false,
        'enablePhone' => true,
        'enableCaptcha' => false,
    ];

    public static $installConfig = [
        'title' => [
            'en' => 'Feedback',
            'ru' => 'Обратная связь',
        ],
        'icon' => 'earphone',
        'order_num' => 60,
    ];
}
