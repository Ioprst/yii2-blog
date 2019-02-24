<?php
/**
 * Project: yii2-blog for internal using
 * Author: diazoxide
 * Copyright (c) 2018.
 */

use diazoxide\yii2blog\Module;

/* @var $this yii\web\View */
/* @var $model diazoxide\yii2blog\models\BlogCategory */

$this->title = Module::t('blog', 'Create ') . Module::t('blog', 'Blog Category');
$this->params['breadcrumbs'][] = ['label' => Module::t('blog', 'Blog Categorys'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="blog-category-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
