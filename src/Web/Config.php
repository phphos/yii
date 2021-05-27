<?php

namespace PHPHos\Yii\Web;

class Config
{
    public static function main(): array
    {
        return [
            'id' => 'app',
            'timeZone' => 'PRC',
            'language' => 'zh-CN',
        ];
    }

    public static function user(): array
    {
        return [
            'class' => 'PHPHos\Yii\Web\User',
            'identityClass' => 'PHPHos\Yii\Web\UserIdentity',
            'enableAutoLogin' => false,
            'enableSession' => false,
        ];
    }

    public static function cache(): array
    {
        return ['class' => 'yii\caching\FileCache'];
    }

    public static function request(): array
    {
        return [
            'cookieValidationKey' => '05368BD30A33FA6CA6AB3F691D3D41D0',
            'enableCsrfValidation' => false,
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ],
        ];
    }

    public static function response(): array
    {
        return [
            'class' => 'yii\web\Response',
            'format' => \yii\web\Response::FORMAT_JSON,
            'charset' => 'UTF-8',
            'on beforeSend' => function ($event) {
                $model = new \PHPHos\Yii\Web\Response;
                $model->event = $event;
                $model->callback = 'PHPHos\Yii\Models\ChangeLog::add';
                $model->beforeSend();
            }
        ];
    }

    public static function error(): array
    {
        return ['class' => 'PHPHos\Yii\Exceptions\ErrorHandler'];
    }

    public static function url(): array
    {
        return [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => [
                '<module:[\w-]+>' => '<module>',
                '<module:[\w-]+>/<controller:[\w-]+>' =>
                '<module>/<controller>',
                '<module:[\w-]+>/<controller:[\w-]+>/<action:[\w-]+>' =>
                '<module>/<controller>/<action>',
            ],
        ];
    }

    public static function gii(): array
    {
        return [
            'class' => 'yii\gii\Module',
            'allowedIPs' => ['*'], // ['127.0.0.1', '::1'].
            'generators' => [
                'model' => [
                    'class' => 'PHPHos\Yii\Templates\Model\Generator',
                    'templates' => [
                        'RESTfulModel' => '@vendor/PHPHos/Yii/src/Templates/Model/Restful',
                    ],
                ],
            ],
        ];
    }
}
