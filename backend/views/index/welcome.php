
<div class="x-body layui-anim layui-anim-up">
    <blockquote class="layui-elem-quote">欢迎<?= $role['name'] ?>：<span class="x-red"><?= $user['name'] ?></span>！&nbsp;&nbsp;
        当前时间：<span style="color: #009688" id="time"></span></blockquote>
    <fieldset class="layui-elem-field">
        <legend>数据统计</legend>
        <div class="layui-field-box">
            <div class="layui-col-md12">
                <div class="layui-card">
                    <div class="layui-card-body">
                        <div class="layui-carousel x-admin-carousel x-admin-backlog" lay-anim="" lay-indicator="inside" lay-arrow="none" style="width: 100%; height: 90px;">
                            <div carousel-item="">
                                <ul class="layui-row layui-col-space10 layui-this">
                                    <li class="layui-col-xs2">
                                        <a href="javascript:;" class="x-admin-backlog-body">
                                            <h3>文章数</h3>
                                            <p>
                                                <cite>66</cite></p>
                                        </a>
                                    </li>
                                    <li class="layui-col-xs2">
                                        <a href="javascript:;" class="x-admin-backlog-body">
                                            <h3>会员数</h3>
                                            <p>
                                                <cite>12</cite></p>
                                        </a>
                                    </li>
                                    <li class="layui-col-xs2">
                                        <a href="javascript:;" class="x-admin-backlog-body">
                                            <h3>回复数</h3>
                                            <p>
                                                <cite>99</cite></p>
                                        </a>
                                    </li>
                                    <li class="layui-col-xs2">
                                        <a href="javascript:;" class="x-admin-backlog-body">
                                            <h3>商品数</h3>
                                            <p>
                                                <cite>67</cite></p>
                                        </a>
                                    </li>
                                    <li class="layui-col-xs2">
                                        <a href="javascript:;" class="x-admin-backlog-body">
                                            <h3>文章数</h3>
                                            <p>
                                                <cite>67</cite></p>
                                        </a>
                                    </li>
                                    <li class="layui-col-xs2">
                                        <a href="javascript:;" class="x-admin-backlog-body">
                                            <h3>文章数</h3>
                                            <p>
                                                <cite>6766</cite></p>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </fieldset>
    <fieldset class="layui-elem-field">
        <legend>系统信息</legend>
        <div class="layui-field-box">
            <table class="layui-table">
                <tbody>
                <tr>
                    <th>Yii2版本</th>
                    <td><?= $sys['yiiVersion'] ?></td></tr>
                <tr>
                    <th>服务器地址</th>
                    <td><?= $sys['serverAddress'] ?></td></tr>
                <tr>
                    <th>操作系统</th>
                    <td><?= $sys['os'] ?></td></tr>
                <tr>
                    <th>运行环境</th>
                    <td><?= $sys['environment'] ?></td></tr>
                <tr>
                    <th>PHP版本</th>
                    <td><?= $sys['phpVersion'] ?></td></tr>
                <tr>
                    <th>PHP运行方式</th>
                    <td><?= $sys['operationMode'] ?></td></tr>
                <tr>
                    <th>MYSQL版本</th>
                    <td><?= $sys['mysqlVersion'] ?></td></tr>
                <tr>
                    <th>上传附件限制</th>
                    <td><?= $sys['uploadLimit'] ?></td></tr>
                <tr>
                    <th>执行时间限制</th>
                    <td><?= $sys['execTime'] ?> s</td></tr>
                <tr>
                    <th>剩余空间</th>
                    <td><?= $sys['freeSpace'] ?> G</td></tr>
                </tbody>
            </table>
        </div>
    </fieldset>
    <blockquote class="layui-elem-quote layui-quote-nm">感谢layui,X-admin,Yii2。本系统由Zeyen 提供技术支持。</blockquote>
</div>

<?php $this->beginBlock('footer') ?>
<script>
    // 页面时钟
    $(function () {
        ShowTime();
    });

    // 显示时间
    function ShowTime() {
        var date = new Date();
        var year = date.getFullYear();
        var month = date.getMonth() + 1;
        var day = date.getDate();
        var hour = date.getHours();
        var minutes = date.getMinutes();
        var second = date.getSeconds();
        var timeStr = year + "-" + check(month) + "-" + check(day) + "&nbsp;&nbsp;" + check(hour)
            + ":" + check(minutes) + ":" + check(second);
        document.getElementById("time").innerHTML = timeStr;
        setTimeout('ShowTime()', 1000);
    }

    // 不满10，补0
    function check(val) {
        if (val < 10) {
            return ("0" + val);
        } else {
            return (val);
        }
    }
</script>
<?php $this->endBlock() ?>
