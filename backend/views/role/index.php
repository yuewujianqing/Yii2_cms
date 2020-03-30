<?php
use yii\helpers\Url;
?>

<div class="x-nav">
      <span class="layui-breadcrumb">
        <a href="javascript:;">首页</a>
        <a href="javascript:;">管理员管理</a>
        <a href="javascript:;"><cite>管理员列表</cite></a>
      </span>
    <a class="layui-btn layui-btn-small refresh-btn" href="javascript:location.replace(location.href);" title="刷新">
        <i class="layui-icon" style="line-height:38px">ဂ</i></a>
</div>
<div class="x-body">
    <div class="layui-row">
        <form class="layui-form layui-col-md12 x-so">
            <input type="text" name="search[name]"  placeholder="角色名" autocomplete="off" class="layui-input"
                   value="<?= isset($search['name']) ? $search['name'] : '' ?>">
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
        <button class="layui-btn layui-btn-danger" onclick="batch_del('<?= Url::to(['role/batch-del']) ?>')"><i class="layui-icon"></i>批量删除</button>
        <button class="layui-btn" onclick="x_admin_show('添加','<?=  Url::to(['role/create']) ?>')"><i class="layui-icon"></i>添加</button>
        <span class="x-right" style="line-height:40px">共有数据：<span class="count_num"><?= $pagination->totalCount ?></span> 条 ( <?= $pagination->getPageCount() ?> 页 )</span>
    </xblock>
    <table class="layui-table">
        <thead>
        <tr>
            <th>
                <div class="layui-unselect header layui-form-checkbox" lay-skin="primary"><i class="layui-icon">&#xe605;</i></div>
            </th>
            <th>ID</th>
            <th>角色名</th>
            <th>描述</th>
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
            <td><?= $list['description'] ?></td>
            <td class="td-manage">
                <a title="编辑"  onclick="x_admin_show('编辑','<?= Url::to(['role/update', 'id' => $list['id']]) ?>')" href="javascript:;">
                    <i class="layui-icon">&#xe642;</i>
                </a>
                <a title="删除" onclick="del(this, '<?= $list['id'] ?>', '<?= Url::to(['role/del']) ?>')" href="javascript:;">
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
