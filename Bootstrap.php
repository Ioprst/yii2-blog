<?php
namespace diazoxide\blog;

use yii\base\BootstrapInterface;
use yii\i18n\PhpMessageSource;

class Bootstrap implements BootstrapInterface
{
    /**
     * @inheritdoc
     */
    public function bootstrap($app)
    {
        // Add module URL rules.
        $app->getUrlManager()->addRules(
            [
                '/category/<slug>' => '/blog/default/archive',
                '/archive' => '/blog/default/archive',
                [
                    'pattern' => '<year:\d{4}>/<month:\d{2}>/<day:\d{2}>/<slug>',
                    'route' => '/blog/default/view',
                    'suffix' => '/'
                ],
                //Fixing old posts issue
                '/archives/<id:\d+>' => '/site/old-post',
            ]
        );
        // Add module I18N category.
        if (!isset($app->i18n->translations['diazoxide/blog'])) {
            $app->i18n->translations['diazoxide/blog'] = [
                'class' => PhpMessageSource::class,
                'basePath' => __DIR__ . '/messages',
                'forceTranslation' => true,
                'fileMap' => [
                    'diazoxide/blog' => 'blog.php',
                ]
            ];
        }

        \Yii::setAlias('@diazoxide', \Yii::getAlias('@vendor') . '/diazoxide');
    }
}