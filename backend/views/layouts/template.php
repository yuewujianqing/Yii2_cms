<?php
/* @var $this \yii\web\View */
use yii\helpers\Url;
?>

// header
<?php $this->beginContent('@app/views/layouts/header.php') ?>
<?php $this->endContent() ?>

<?= $this->render('header') ?>

// footer
<?php $this->beginContent('@app/views/layouts/footer.php') ?>
<?php $this->endContent() ?>

<?= $this->render('footer') ?>

// pagination
<?= $this->render('@app/views/layouts/pagination', compact('pagination')) ?>

// css
<?php $this->beginBlock('header') ?>
<style>

</style>
<?php $this->endBlock() ?>

// js
<?php $this->beginBlock('footer') ?>
<script>

</script>
<?php $this->endBlock() ?>

// user
<?php if (Yii::$app->user->isGuest): ?>

<?php else: ?>

<?php endif; ?>
