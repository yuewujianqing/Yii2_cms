<?php
use yii\helpers\Url;
?>
<div class="login layui-anim layui-anim-up">
    <div class="message">管理登录</div>
    <div id="darkbannerwrap"></div>

    <form method="post" class="layui-form" >
        <input name="name" placeholder="用户名"  type="text" lay-verify="required" class="layui-input" >
        <hr class="hr15">
        <input name="password" lay-verify="required" placeholder="密码"  type="password" class="layui-input">
        <hr class="hr15">
        <input value="登录" lay-submit="" lay-filter="login" style="width:100%;" type="submit">
        <hr class="hr20" >
    </form>
</div>

<?php $this->beginBlock('footer') ?>
<script>
    $('body').addClass('login-bg');
    $(function  () {
        layui.use('form', function(){
            var form = layui.form;
            form.on('submit(login)', function(data){
                layer.load(3);
                $.post('<?= Url::to(['site/login']) ?>', data.field, function (res) {
                    layer.closeAll();
                    if (res.status === 200) {
                        layer.msg(res.msg, {icon: 1,time: 1500}, function () {
                            location.href = '<?= Url::to(['/']) ?>';
                        })
                    } else {
                        layer.msg(res.msg, {icon: 2})
                    }
                }, 'json');
                return false;
            });
        });
    })
</script>
<?php $this->endBlock() ?>
