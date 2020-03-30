<?php
use yii\helpers\Url;
?>
<div class="x-body layui-anim layui-anim-up">
        <form class="layui-form">
            <div class="layui-form-item">
                <label for="name" class="layui-form-label">
                    <span class="x-red">*</span> 用户名
                </label>
                <div class="layui-input-inline">
                    <input type="hidden" name="id" value="<?= $user['id'] ?>">
                    <input type="text" id="name" name="name" required=""
                           autocomplete="off" class="layui-input" value="<?= $user['name'] ?>">
                </div>
                <div class="layui-form-mid layui-word-aux">
                    <span class="x-red">*</span> 将会成为您唯一的登入名
                </div>
            </div>
            <div class="layui-form-item">
                <label for="pwd" class="layui-form-label">
                    角色
                </label>
                <div class="layui-input-inline">
                    <select name="role_id" id="role_id">
                        <?php foreach ($roles as $list): ?>
                            <option value="<?= $list['id'] ?>" <?= $list['id'] == $user['role_id'] ? 'selected' : '' ?>><?= $list['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">状态</label>
                <div class="layui-input-block">
                    <input type="radio" value="1" name="status" lay-skin="primary" title="启用" <?= $user['status'] == 1 ? 'checked' : '' ?>>
                    <input type="radio" value="2" name="status" lay-skin="warning" title="禁用" <?= $user['status'] == 2 ? 'checked' : '' ?>>
                </div>
            </div>
            <div class="layui-form-item">
                <label for="pwd" class="layui-form-label">
                    密码
                </label>
                <div class="layui-input-inline">
                    <input type="password" id="pwd" name="pwd" lay-verify="pwd"
                           autocomplete="off" class="layui-input">
                </div>
                <div class="layui-form-mid layui-word-aux">
                    <span class="x-red">*</span> 默认为空，表示不更新密码
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
            $.post('<?= Url::to(['user/update']) ?>', data.field, function (res) {
                layer.closeAll();
                if (res.status === 200) {
                    layer.msg(res.msg, {icon: 1, time: 1500}, function () {
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