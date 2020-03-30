<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\helpers\Url;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <title>Yii2通用管理系统</title>
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <?= Html::csrfMetaTags() ?>
    <link rel="shortcut icon" href="<?= Url::to('@web/favicon.ico') ?>" type="image/x-icon" />
    <link rel="stylesheet" href="http://at.alicdn.com/t/font_1102529_22kdtws4r72.css">
    <script type="text/javascript" src="<?= Url::to('@web/js/jquery.min.js') ?>"></script>
    <?php $this->head() ?>

    <?php if (isset($this->blocks['header'])): ?>
        <?= $this->blocks['header']; ?>
    <?php endif; ?>

</head>

<body style="display: none">
<?php $this->beginBody() ?>

<?= $content ?>

<?php $this->endBody() ?>
</body>

<?php if (isset($this->blocks['footer'])): ?>
    <?= $this->blocks['footer']; ?>
<?php endif; ?>

<script>
    // 解决页面样式抖动
    $(function () {
        $('body').css({'display': 'block'})
    })
</script>
</html>
<?php $this->endPage() ?>
