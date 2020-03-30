
// jsonp 请求数据格式
// 示例数据：
// 1：window.suggest360({q:"360",p:true,s:["360安全卫士下载","360安全浏览器","360软件管家","360搜索app","360游戏大厅","360云平台","360云盘","360影视","360天气","360浏览器"]})
// 2：portraitCallBack({"811687790":["http://qlogo3.store.qq.com/qzone/811687790/811687790/100",3718,-1,0,0,0,"my",0]})

// QQ接口
jQuery(document).ready(function () {
    var qq = "574201314";
    /* 定义QQ号为574201314 */
    $.ajax({
        /* 使用ajax请求 */
        type: "get", /* 请求方式为GET */
        url: "http://r.qzone.qq.com/fcg-bin/cgi_get_portrait.fcg?uins=" + qq, /* 发送请求的地址 */
        dataType: "jsonp", /* 返回JSONP格式 */
        jsonp: "callback", /* 重写回调函数名 */
        jsonpCallback: "portraitCallBack", /* 指定回调函数名 */
        success: function (json) {  /* 请求成功输出 */
            for (var key in json) {
                alert("QQ：" + key);
                /* 弹出：QQ：574201314 */
            }
            alert("昵称：" + json[qq][6]);
            /* 弹出：昵称：冷逸尘*/
            alert("头像地址：" + json[qq][0]);
            /* 弹出：QQ空间头像地址：http://qlogo4.store.qq.com/qzone/574201314/574201314/100 */
        },
        error: function () {  /* 请求失败输出 */
            alert('获取失败');
        }
    });
});

// 360接口 done、fail写法
$(function () {
    $('#txt01').keyup(function () {
        var val = $(this).val();
        $.ajax({
            url: 'https://sug.so.360.cn/suggest?',//请求360搜索的公开接口
            type: 'get',
            dataType: 'jsonp',//跨域请求
            data: {word: val}//携带参数
        })
            .done(function (data) {
                console.log(data);
                // alert(data.s.length);//10条数据
                $('.list').empty();//先清空列表
                //模拟搜索联想，循环插入新列表
                for (var i = 0; i < data.s.length; i++) {
                    var $li = $('<li>' + data.s[i] + '</li>');
                    $li.prependTo('.list');
                }
            })
            .fail(function () {
                console.log("error");
            });
    })
})
