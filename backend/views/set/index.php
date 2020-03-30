<?php
use yii\helpers\Url;
?>

<?php $this->beginBlock('header') ?>
<style>
    .layui-form-pane .layui-form-label {width: 200px}
    .layui-form-pane .layui-input-block {margin-left: 200px}
    .layui-input-inline img {width: 100px; height: 100px; border: 1px solid #ccc; box-sizing: border-box}
    .img-item .layui-form-label{height: 100px; line-height: 80px}
</style>
<?php $this->endBlock() ?>

<div class="x-nav">
      <span class="layui-breadcrumb">
        <a href="javascript:;">首页</a>
        <a href="javascript:;">系统设置</a>
        <a href="javascript:;">
          <cite>系统设置列表</cite>
        </a>
      </span>
    <a class="layui-btn layui-btn-small refresh-btn" href="javascript:location.replace(location.href);" title="刷新">
        <i class="layui-icon" style="line-height:38px">ဂ</i></a>
</div>

<div class="x-body">
    <div class="layui-tab layui-tab-brief">
        <ul class="layui-tab-title">
            <li class="layui-this">网站设置</li>
            <li>图片设置</li>
        </ul>
        <div class="layui-tab-content" >
            <div class="layui-tab-item layui-show">
                <form class="layui-form layui-form-pane" action="">
                    <?php foreach ($texts as $list): ?>
                    <div class="layui-form-item">
                        <label class="layui-form-label">
                            <span class='x-red'>*</span> <?= $list['desc'] ?>
                        </label>
                        <div class="layui-input-block sys-text">
                            <input type="text" name="title" autocomplete="off" class="layui-input" data-id="<?= $list['id'] ?>"
                                   value="<?= $list['value'] ?>">
                        </div>
                    </div>
                    <?php endforeach; ?>
                </form>
                <div style="height:100px;"></div>
            </div>
            <div class="layui-tab-item">
                <form class="layui-form layui-form-pane" action="">
                    <?php foreach ($images as $list): ?>
                    <div class="layui-form-item img-item" >
                        <label class="layui-form-label">
                            <span class='x-red'>*</span> <?= $list['desc'] ?>
                        </label>
                        <div class="layui-input-inline sys-img">
                            <img src="<?= $list['value'] ? Url::to('@web' . $list['value']) : Url::to('@web/images/add_img.png') ?>"
                                 data-id="<?= $list['id'] ?>">
                        </div>
                    </div>
                    <?php endforeach; ?>
                </form>
            </div>
        </div>
    </div>
</div>

<form id="uploadForm" enctype="multipart/form-data" style="display: none">
    <input type="file" name="file" id="file">
</form>

<?php $this->beginBlock('footer') ?>
<script>
    $('.sys-text input').blur(function () {
        var id = $(this).attr('data-id');
        var val = $(this).val();
        layer.load(3);
        $.post('<?= Url::to(['set/change-text']) ?>', {id: id, val: val}, function (res) {
            layer.closeAll();
            if (res.status !== 200) {
                layer.msg(res.msg, {icon: 2, time: 1500})
            }
        }, 'json');
    })

    $('.sys-img img').click(function () {
        var id = $(this).attr('data-id');
        var fileObj = $('#file');
        var that = $(this);
        fileObj.unbind().click();
        fileObj.change(function(){
            layer.load(3);
            $.ajax({
                url: '<?= Url::to(['set/change-img']) ?>',
                type: 'POST',
                cache: false,
                data: new FormData($('#uploadForm')[0]),
                dataType:'JSON',
                processData: false,
                contentType: false
            }).done(function(res) {
                layer.closeAll();
                if (res.status === 100) {
                    layer.msg(res.msg, {icon: 2, time: 1500}); return;
                }
                that.attr('src', res.data);
                layer.load(3);
                $.get('<?= Url::to(['set/change-img']) ?>', {id: id, val: res.data}, function (res) {
                    layer.closeAll();
                    console.log(res)
                }, 'json')
            });
        });
    })

</script>
<?php $this->endBlock() ?>