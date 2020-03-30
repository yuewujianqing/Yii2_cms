<?php
use yii\helpers\Url;
?>

<div class="x-nav">
      <span class="layui-breadcrumb">
        <a href="javascript:;">首页</a>
        <a href="javascript:;">日志管理</a>
        <a href="javascript:;">
          <cite>登陆日志</cite>
        </a>
      </span>
    <a class="layui-btn layui-btn-small refresh-btn" href="javascript:location.replace(location.href);" title="刷新">
        <i class="layui-icon" style="line-height:38px">ဂ</i></a>
</div>
<div class="x-body">
    <div class="layui-row">
        <form class="layui-form layui-col-md12 x-so">
            <input type="text" name="search[name]"  placeholder="用户名"
                   value="<?= isset($search['name']) ? $search['name'] : '' ?>" autocomplete="off" class="layui-input">
            <input type="text" name="search[ip]"  placeholder="IP"
                   value="<?= isset($search['ip']) ? $search['ip'] : '' ?>" autocomplete="off" class="layui-input">
            <input class="layui-input" placeholder="开始日" name="search[b_time]" id="start"
                   value="<?= isset($search['b_time']) ? $search['b_time'] : '' ?>" autocomplete="off">
            <input class="layui-input" placeholder="截止日" name="search[e_time]" id="end"
                   value="<?= isset($search['e_time']) ? $search['e_time'] : '' ?>" autocomplete="off">
            <button class="layui-btn" type="submit"><i class="layui-icon">&#xe615;</i></button>
            <button class="layui-btn" type="button" onclick="location.href= '<?= Url::to([$this->context->id . '/index'])?>'" >
                <i class="layui-icon">&#xe666;</i>
            </button>
        </form>
    </div>
    <xblock>
        <button class="layui-btn layui-btn-danger" onclick="batch_del('<?= Url::to([$this->context->id . '/batch-del']) ?>')"><i class="layui-icon"></i>批量删除</button>
        <span class="x-right" style="line-height:40px">共有数据：<span class="count_num"><?= $pagination->totalCount ?></span> 条 ( <?= $pagination->getPageCount() ?> 页 )</span>
    </xblock>
    <table class="layui-table">
        <thead>
        <tr>
            <th>
                <div class="layui-unselect header layui-form-checkbox" lay-skin="primary"><i class="layui-icon">&#xe605;</i></div>
            </th>
            <th>ID</th>
            <th>用户名</th>
            <th>IP地址</th>
            <th>位置</th>
            <th>浏览器</th>
            <th>操作系统</th>
            <th>登陆时间</th>
            <th>操作</th>
        </thead>
        <tbody>
        <?php foreach ($models as $list): ?>
            <tr>
                <td>
                    <div class="layui-unselect layui-form-checkbox" lay-skin="primary" data-id='<?= $list['id']?>'><i class="layui-icon">&#xe605;</i></div>
                </td>
                <td><?= $list['id'] ?></td>
                <td><?= $list['user']['name'] ?></td>
                <td><?= $list['ip'] ?></td>
                <td><?= $list['address'] ?></td>
                <td><?= $list['browser'] ?></td>
                <td><?= $list['os'] ?></td>
                <td><?= date('Y-m-d H:i:s', $list['create_time']) ?></td>
                <td class="td-manage">
                    <a title="查看UA"
                       onclick="view('<?= $list['id'] ?>', '<?= Url::to([$this->context->id . '/view']) ?>')"
                       href="javascript:;">
                        <i class="layui-icon">&#xe63c;</i>
                    </a>
                    <a title="删除" onclick="del(this,'<?= $list['id'] ?>', '<?= Url::to([$this->context->id . '/del']) ?>')" href="javascript:;">
                        <i class="layui-icon">&#xe640;</i>
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <?php if (empty($models)): ?>
        <p class="text-empty">-- 暂无数据 --</p>
    <?php endif; ?>

    <?= $this->render('@app/views/layouts/pagination', compact('pagination')) ?>

</div>

<?php $this->beginBlock('footer') ?>
<script>
    function view(id, url) {
        layer.load(3);
        $.post(url, {id: id}, function (res) {
            layer.closeAll();
            if (res.status === 200) {
                layer.open({
                    title: '查看UA',
                    type: 1,
                    area: ['90%', '90%'],
                    content: '<div style="padding: 20px">' + res.data + '</div>'
                });
            } else {
                layer.msg(res.msg, {icon: 2, time: 1500})
            }
        }, 'json');
    }

</script>
<?php $this->endBlock() ?>
