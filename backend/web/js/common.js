
layui.use('laydate', function(){
    var laydate = layui.laydate;

    //执行一个laydate实例
    laydate.render({
        elem: '#start' //指定元素
    });

    //执行一个laydate实例
    laydate.render({
        elem: '#end' //指定元素
    });
});

function del(obj, id, url){
    layer.confirm('确认要删除吗？', {icon: 3},function(index){
        $.get(url, {id: id}, function (res) {
            if (res.status === 200) {
                layer.msg(res.msg, {icon: 1, time: 1500}, function () {
                    $(obj).parents("tr").remove();
                    $count_num = $('.count_num');
                    $count_num.text(parseInt($count_num.text()) - 1);
                })
            } else {
                layer.msg(res.msg, {icon: 2, time: 2000})
            }
        }, 'json');
    });
}

function batch_del (url) {
    var data = tableCheck.getData();
    if (data.length == 0) {
        layer.msg('请选择您要批量删除的数据', {icon: 7}); return;
    }
    layer.confirm('确认要批量删除吗？', {icon: 3}, function(index){
        $.get(url, {idArr: data}, function (res) {
            if (res.status === 200) {
                // $(".layui-form-checked").not('.header').parents('tr').remove();
                layer.msg(res.msg, {icon: 1, time: 1500}, function () {
                    location.reload();
                })
            } else {
                layer.msg(res.msg, {icon: 2, time: 2000})
            }
        }, 'json')
    });
}