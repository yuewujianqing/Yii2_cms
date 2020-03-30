
<div class="page">
    <?= \yii\widgets\LinkPager::widget([
        'pagination' => $pagination,
        'nextPageLabel' => '&gt;&gt;',
        'prevPageLabel' => '&lt;&lt;',
        'firstPageLabel' => '首页',
        'lastPageLabel' => '尾页',
    ]); ?>
</div>