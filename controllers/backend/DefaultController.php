<?php
/**
 * Project: yii2-blog for internal using
 * Author: diazoxide
 * Copyright (c) 2018.
 */

namespace diazoxide\blog\controllers\backend;

use diazoxide\blog\models\BlogPost;
use diazoxide\blog\Module;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

/**
 * @property Module module
 */
class DefaultController extends BaseAdminController
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'regenerate-thumbnails' => ['POST'],
                ],
            ],

            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'thumbnails', 'regenerate-thumbnails'],
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['@', '?']
                    ],
                    [
                        'actions' => ['thumbnails', 'regenerate-thumbnails'],
                        'allow' => true,
                        'roles' => ['BLOG_REGENERATE_THUMBNAILS']
                    ],
                ]
            ]

        ];
    }

    /**
     * @return string
     */
    public function actionIndex()
    {
        if (Yii::$app->user->isGuest) {
            $this->redirect("user/login");
        }
        return $this->render('index');
    }

    public function actionThumbnails()
    {
        $post_count = BlogPost::find()->count();
        return $this->render('thumbnails', [
            'count' => $post_count
        ]);
    }

    public function actionRegenerateThumbnails($offset, $limit)
    {

        $posts = BlogPost::find()->orderBy(['id' => SORT_DESC])->limit($limit)->offset($offset)->all();
        foreach ($posts as $key => $post) {
            $post->createThumbs();
        }

        echo Module::t(null, 'Thumbnails Generation Done: ' . $offset . ' - ' . ($limit + $offset)) . PHP_EOL;

    }
}
