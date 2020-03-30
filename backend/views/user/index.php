<?php
use yii\helpers\Url;
?>

<div class="x-nav">
      <span class="layui-breadcrumb">
        <a href="javascript:;">首页</a>
        <a href="javascript:;">管理员管理</a>
        <a href="javascript:;">
          <cite>管理员列表</cite>
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
        <button class="layui-btn layui-btn-danger" onclick="batch_del('<?= Url::to(['user/batch-del']) ?>')"><i class="layui-icon"></i>批量删除</button>
        <button class="layui-btn" onclick="x_admin_show('添加用户','<?=  Url::to(['user/create']) ?>')"><i class="layui-icon"></i>添加</button>
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
            <th>角色</th>
            <th>创建时间</th>
            <th>状态</th>
            <th>操作</th>
        </thead>
        <tbody>
        <?php foreach ($models as $list): ?>
            <tr>
                <td>
                    <div class="layui-unselect layui-form-checkbox" lay-skin="primary" data-id='<?= $list['id']?>'><i class="layui-icon">&#xe605;</i></div>
                </td>
                <td><?= $list['id'] ?></td>
                <td><?= $list['name'] ?></td>
                <td><?= $list['role']['name'] ?></td>
                <td><?= date('Y-m-d H:i:s', $list['create_time']) ?></td>
                <td class="td-status">
                    <span class="layui-form" onclick="changeStatus('<?= $list['id'] ?>', '<?= $list['status'] ?>')">
                        <input type="checkbox" name="status" lay-skin="switch" lay-text="启用|禁用"
                            <?= $list['status'] == 1 ? 'checked' : '' ?> <?= $list['id'] ==1 ? 'disabled' : '' ?>>
                    </span>
                <td class="td-manage">
                    <a title="编辑"  onclick="x_admin_show('编辑','<?= Url::to(['user/update', 'id' => $list['id']])?>')" href="javascript:;">
                        <i class="layui-icon">&#xe642;</i>
                    </a>
                    <a title="删除" onclick="del(this,'<?= $list['id'] ?>', '<?= Url::to(['user/del']) ?>')" href="javascript:;">
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
    function changeStatus(id, status) {
        if (id == 1) {
            layer.msg('admin禁止禁用', {icon: 2, time: 2000});
            return false;
        }
        layer.load(3);
        $.post('<?= Url::to([$this->context->id .'/change-status']) ?>', {id: id, status: status}, function (res) {
            layer.closeAll();
            var icon = 2;
            if (res.status === 200){
                icon = 1;
            }
            layer.msg(res.msg, {icon: icon, time: 1500})
        }, 'json')
    }
</script>
<?php $this->endBlock() ?>
