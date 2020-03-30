<?php
use yii\helpers\Url;
?>
<!-- 顶部开始 -->
<div class="container" style="color: rgb(60, 63, 65)">
    <div class="logo"><a href="/">Yii2通用管理系统</a></div>
    <div class="left_open">
        <i title="展开左侧栏" class="iconfont">&#xe699;</i>
    </div>
    <ul class="layui-nav left fast-add" lay-filter="">
        <li class="layui-nav-item">
            <a href="javascript:;">+ 新增</a>
            <dl class="layui-nav-child"> <!-- 二级菜单 -->
                <dd><a onclick="x_admin_show('资讯','http://www.baidu.com')"><i class="iconfont">&#xe6a2;</i>资讯</a></dd>
                <dd><a onclick="x_admin_show('图片','http://www.baidu.com')"><i class="iconfont">&#xe6a8;</i>图片</a></dd>
                <dd><a onclick="x_admin_show('用户','http://www.baidu.com')"><i class="iconfont">&#xe6b8;</i>用户</a></dd>
            </dl>
        </li>
    </ul>
    <ul class="layui-nav right" lay-filter="">
        <li class="layui-nav-item to-index"><a href="javascript:;" title="清除缓存" onclick="clear_cache()"><i class="iconfont iconqingchuhuancun" style="color: #00AA88"></i></a></li>
        <li class="layui-nav-item">
            <a href="javascript:;"><i class="layui-icon" style="margin-right: 6px;color: #5FB878">&#xe66f;</i><?= Yii::$app->user->identity->name ?></a>
            <dl class="layui-nav-child"> <!-- 二级菜单 -->
                <dd><a onclick="x_admin_show('个人信息', '<?= Url::to(['user/update', 'id' => Yii::$app->user->getId()]) ?>')">个人信息</a></dd>
                <dd><a href="<?= Url::to(['site/logout']) ?>">退出</a></dd>
            </dl>
        </li>
    </ul>
</div>
<!-- 顶部结束 -->

<!-- 中部开始 -->

<!-- 左侧菜单开始 -->
<div class="left-nav">
    <div id="side-nav">
        <ul id="nav">
            <?php foreach ($menu as $list): ?>
            <li>
                <a href="javascript:;">
                    <i class="iconfont"><?= $list['icon'] ?></i>
                    <cite><?= $list['name'] ?></cite>
                    <i class="iconfont nav_right">&#xe697;</i>
                </a>
                <ul class="sub-menu">
                    <?php foreach ($list['submenu'] as $item): ?>
                    <li>
                        <a _href="<?= Url::to([$item['route']]) ?>">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite><?= $item['route_name'] ?></cite>
                        </a>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>
<!-- <div class="x-slide_left"></div> -->
<!-- 左侧菜单结束 -->

<!-- 右侧主体开始 -->
<div class="page-content">
    <div class="layui-tab tab" lay-filter="xbs_tab" lay-allowclose="false">
        <ul class="layui-tab-title">
            <li class="home"><i class="layui-icon">&#xe68e;</i>我的桌面</li>
        </ul>
        <div class="layui-tab-content">
            <div class="layui-tab-item layui-show">
                <iframe src='<?= Url::to(['index/welcome'])?>' frameborder="0" scrolling="yes" class="x-iframe"></iframe>
            </div>
        </div>
    </div>
</div>
<div class="page-content-bg"></div>
<!-- 右侧主体结束 -->
<!-- 中部结束 -->
<!-- 底部开始 -->
<div class="footer">
    <div class="copyright">Copyright ©<?= date('Y') ?> Zeyen CMS All Rights Reserved</div>
</div>

<?php $this->beginBlock('footer') ?>
<script>
    function clear_cache() {
        layer.load(3);
        $.post('<?= Url::to(['index/clear-cache']) ?>',{id: 1} , function (res) {
            layer.closeAll();
            if (res.status === 200) {
                layer.msg(res.msg, {icon: 1,time: 1500}, function () {
                    location.reload();
                })
            } else {
                layer.msg(res.msg, {icon: 2, time: 1500})
            }
        }, 'json');
    }
</script>
<?php $this->endBlock() ?>
