<?php
use yii\helpers\Url;
?>
<div class="x-body layui-anim layui-anim-up">
    <form class="layui-form">
        <div class="layui-form-item">
            <label for="nickname" class="layui-form-label">昵称</label>
            <div class="layui-input-inline">
                <input type="text" id="nickname" name="nickname" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label for="email" class="layui-form-label">邮箱</label>
            <div class="layui-input-inline">
                <input type="text" id="email" name="email" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label for="tel" class="layui-form-label">
                <span class="x-red">*</span> 手机号码
            </label>
            <div class="layui-input-inline">
                <input type="text" id="tel" name="tel" required="" lay-verify="phone"
                       autocomplete="off" class="layui-input">
            </div>
            <div class="layui-form-mid layui-word-aux">
                <span class="x-red">*</span> 将会成为您唯一的登入名
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">状态</label>
            <div class="layui-input-block">
                <input type="radio" value="1" name="status" lay-skin="primary" title="启用" checked="">
                <input type="radio" value="2" name="status" lay-skin="warning" title="禁用">
            </div>
        </div>
        <div class="layui-form-item">
            <label for="pwd" class="layui-form-label">
                <span class="x-red">*</span> 密码
            </label>
            <div class="layui-input-inline">
                <input type="password" id="pwd" name="pwd" lay-verify="pwd"
                       autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label for="" class="layui-form-label">
            </label>
            <button  class="layui-btn" lay-filter="add" lay-submit="">
                增加
            </button>
        </div>
    </form>
</div>

<?php $this->beginBlock('footer') ?>
<script>
    layui.use(['form','layer'], function(){
        $ = layui.jquery;
        var form = layui.form ,layer = layui.layer;
        //自定义验证规则示例
        form.verify({
            pwd: function(value){
                if(!value){
                    return '密码不能为空';
                }
            }
        });

        //监听提交
        form.on('submit(add)', function(data){
            layer.load(3);
            $.post('<?= Url::to(['member/create']) ?>', data.field, function (res) {
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