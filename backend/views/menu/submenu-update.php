<?php
use yii\helpers\Url;
?>
<div class="x-body layui-anim layui-anim-up">
    <form class="layui-form">
        <div class="layui-form-item">
            <label for="route_name" class="layui-form-label">
                <span class="x-red">*</span> 子菜单名
            </label>
            <div class="layui-input-inline">
                <input  type="hidden" name="id" value="<?= $model['id'] ?>">
                <input type="text" id="route_name" name="route_name" autocomplete="off" class="layui-input" lay-verify="required" value="<?= $model['route_name']?>">
            </div>
        </div>
        <div class="layui-form-item">
            <label for="route" class="layui-form-label">
                <span class="x-red">*</span> 路由
            </label>
            <div class="layui-input-inline">
                <input type="text" id="route" name="route" autocomplete="off" class="layui-input" lay-verify="required" value="<?= $model['route'] ?>">
            </div>
        </div>
        <div class="layui-form-item">
            <label for="sort" class="layui-form-label">
                排序
            </label>
            <div class="layui-input-inline">
                <input type="number" id="sort" name="sort" autocomplete="off" class="layui-input" value="<?= $model['sort'] ?>">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">状态</label>
            <div class="layui-input-block">
                <input type="radio" value="1" name="is_show" lay-skin="primary" title="显示" <?= $model['is_show'] == 1 ? 'checked' : ''?>>
                <input type="radio" value="2" name="is_show" lay-skin="warning" title="隐藏" <?= $model['is_show'] == 2 ? 'checked' : ''?>>
            </div>
        </div>
        <div class="layui-form-item">
            <label for="" class="layui-form-label">
            </label>
            <button  class="layui-btn" lay-filter="update" lay-submit="">
                更新
            </button>
        </div>
    </form>
</div>

<?php $this->beginBlock('footer') ?>
<script>
    layui.use(['form','layer'], function(){
        $ = layui.jquery;
        var form = layui.form ,layer = layui.layer;

        //监听提交
        form.on('submit(update)', function(data){
            layer.load(3);
            $.post('<?= Url::to([$this->context->id . '/submenu-update']) ?>', data.field, function (res) {
                layer.closeAll();
                if (res.status === 200) {
                    layer.msg(res.msg, {icon: 1,time: 1500}, function () {
                        var index = parent.layer.getFrameIndex(window.name);
                        parent.layer.close(index);
                        parent.location.reload();
                    })
                } else {
                    layer.msg(res.msg, {icon: 2, time: 1500})
                }
            }, 'json');
            return false;
        });
    });
</script>
<?php $this->endBlock() ?>