<?php
/**
 * Project: yii2-blog for internal using
 * Author: diazoxide
 * Copyright (c) 2018.
 */

use diazoxide\blog\models\Status;
use diazoxide\blog\Module;
use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel \diazoxide\blog\models\BlogCommentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Module::t('', 'Blog Comments');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="blog-comment-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    
    <p>
        <?= Html::a(Module::t('', 'Create ') . Module::t('', 'Blog Comment'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= Html::beginForm(['bulk'], 'post'); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\CheckboxColumn'],

            [
                'attribute' => 'post_id',
                'value' => function ($model) {
                    return mb_substr($model->post->title, 0, 15, 'utf-8') . '...';
                },
                /*'filter' => Html::activeDropDownList(
                    $searchModel,
                    'post_id',
                    \diazoxide\blog\models\BlogPost::getArrayCategory(),
                    ['class' => 'form-control', 'prompt' => Module::t('blog', 'Please Filter')]
                )*/
            ],
            [
                'attribute' => 'content',
                'value' => function ($model) {
                    return mb_substr(Yii::$app->formatter->asText($model->content), 0, 30, 'utf-8') . '...';
                },
            ],
            'author',
            'email:email',
            // 'url:url',
            [
                'attribute' => 'status',
                'format' => 'html',
                'value' => function ($model) {
                    if ($model->status === \diazoxide\blog\traits\IActiveStatus::STATUS_ACTIVE) {
                        $class = 'label-success';
                    } elseif ($model->status === \diazoxide\blog\traits\IActiveStatus::STATUS_INACTIVE) {
                        $class = 'label-warning';
                    } else {
                        $class = 'label-danger';
                    }

                    return '<span class="label ' . $class . '">' . $model->getStatus() . '</span>';
                },
                'filter' => Html::activeDropDownList(
                    $searchModel,
                    'status',
                    \diazoxide\blog\models\BlogPost::getStatusList(),
                    ['class' => 'form-control', 'prompt' => Module::t('', 'PROMPT_STATUS')]
                )
            ],

            'created_at:date',
            // 'update_time',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <hr>
    <div class="row">
        <div class="col-md-4">
            <?= Html::dropDownList('action', '',
                [
                    '' => 'Choose',
                    'c' => Module::t('', 'Confirm'),
                    'd' => Module::t('', 'Delete')
                ], ['class' => 'form-control dropdown',]) ?>
        </div>
        <div class="col-md-4">
            <?= Html::submitButton(Module::t('', 'Send'), ['class' => 'btn btn-info',]); ?>
        </div>
    </div>

    <?= Html::endForm(); ?>
</div>
