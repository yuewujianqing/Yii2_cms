<?php
use yii\helpers\Url;
?>
<div class="x-body">
    <form action="" method="post" class="layui-form layui-form-pane">
        <div class="layui-form-item">
            <label for="name" class="layui-form-label">
                <span class="x-red">*</span>角色名
            </label>
            <div class="layui-input-inline">
                <input type="text" id="name" name="name" required="" lay-verify="required"
                       autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item layui-form-text">
            <label for="description" class="layui-form-label">
                描述
            </label>
            <div class="layui-input-block">
                <textarea placeholder="请输入内容" id="description" name="description" class="layui-textarea" style="min-height: 50px"></textarea>
            </div>
        </div>
        <div class="layui-form-item layui-form-text">
            <label class="layui-form-label">
                拥有权限
            </label>
            <table  class="layui-table layui-input-block">
                <tbody>
                <?php foreach ($submenus as $list): ?>
                <tr>
                    <td style="width: 180px" class="submenu_name">
                        <input type="checkbox" name="submenu_name[]" lay-skin="primary" title="<?= $list['route_name'] ?>">
                    </td>
                    <td>
                        <div class="layui-input-block">
                            <?php foreach ($list['route'] as $item): ?>
                            <input name="ids[]" lay-skin="primary" type="checkbox" value="<?= $item['id'] ?>" title="<?= $item['route_name'] ?>">
                            <?php endforeach; ?>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="layui-form-item">
            <button class="layui-btn" lay-submit="" lay-filter="add">增加</button>
        </div>
    </form>
</div>

<?php $this->beginBlock('footer') ?>
<script>
    layui.use(['form','layer'], function(){
        $ = layui.jquery;
        var form = layui.form, layer = layui.layer;

        $('.submenu_name').click(function () {
            if ($(this).find('input').prop('checked')) {
                $(this).next().find('.layui-input-block').find('input').attr('checked', 'checked');
            } else {
                $(this).next().find('.layui-input-block').find('input').removeAttr('checked');
            }
            form.render("checkbox")
        });

        //监听提交
        form.on('submit(add)', function(data){
            layer.load(3);
            $.post('<?= Url::to(['role/create']) ?>', data.field, function (res) {
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