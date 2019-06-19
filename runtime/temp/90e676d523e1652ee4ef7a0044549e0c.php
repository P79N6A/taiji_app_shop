<?php if (!defined('THINK_PATH')) exit(); /*a:5:{s:93:"C:\phpStudy\PHPTutorial\WWW\CRMEB/application/admin\view\record\record\ranking_commission.php";i:1556184114;s:77:"C:\phpStudy\PHPTutorial\WWW\CRMEB\application\admin\view\public\container.php";i:1556184114;s:78:"C:\phpStudy\PHPTutorial\WWW\CRMEB\application\admin\view\public\frame_head.php";i:1556184114;s:73:"C:\phpStudy\PHPTutorial\WWW\CRMEB\application\admin\view\public\style.php";i:1556184114;s:80:"C:\phpStudy\PHPTutorial\WWW\CRMEB\application\admin\view\public\frame_footer.php";i:1556184114;}*/ ?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php if(empty($is_layui) || (($is_layui instanceof \think\Collection || $is_layui instanceof \think\Paginator ) && $is_layui->isEmpty())): ?>
    <link href="/public/system/frame/css/bootstrap.min.css?v=3.4.0" rel="stylesheet">
    <?php endif; ?>
    <link href="/public/static/plug/layui/css/layui.css" rel="stylesheet">
    <link href="/public/system/css/layui-admin.css" rel="stylesheet"></link>
    <link href="/public/system/frame/css/font-awesome.min.css?v=4.3.0" rel="stylesheet">
    <link href="/public/system/frame/css/animate.min.css" rel="stylesheet">
    <link href="/public/system/frame/css/style.min.css?v=3.0.0" rel="stylesheet">
    <script src="/public/system/frame/js/jquery.min.js"></script>
    <script src="/public/system/frame/js/bootstrap.min.js"></script>
    <script src="/public/static/plug/layui/layui.all.js"></script>
    <script>
        $eb = parent._mpApi;
        // if(!$eb) top.location.reload();
        window.controlle="<?php echo strtolower(trim(preg_replace("/[A-Z]/", "_\\0", think\Request::instance()->controller()), "_"));?>";
        window.module="<?php echo think\Request::instance()->module();?>";
    </script>



    <title></title>
    

    <!--<script type="text/javascript" src="/static/plug/basket.js"></script>-->
<script type="text/javascript" src="/public/static/plug/requirejs/require.js"></script>
<?php /*  <script type="text/javascript" src="/static/plug/requirejs/require-basket-load.js"></script>  */ ?>
<script>
    var hostname = location.hostname;
    if(location.port) hostname += ':' + location.port;
    requirejs.config({
        map: {
            '*': {
                'css': '/public/static/plug/requirejs/require-css.js'
            }
        },
        shim:{
            'iview':{
                deps:['css!iviewcss']
            },
            'layer':{
                deps:['css!layercss']
            }
        },
        baseUrl:'//'+hostname+'/public/',
        paths: {
            'static':'static',
            'system':'system',
            'vue':'static/plug/vue/dist/vue.min',
            'axios':'static/plug/axios.min',
            'iview':'static/plug/iview/dist/iview.min',
            'iviewcss':'static/plug/iview/dist/styles/iview',
            'lodash':'static/plug/lodash',
            'layer':'static/plug/layer/layer',
            'layercss':'static/plug/layer/theme/default/layer',
            'jquery':'static/plug/jquery/jquery.min',
            'moment':'static/plug/moment',
            'sweetalert':'static/plug/sweetalert2/sweetalert2.all.min'

        },
        basket: {
            excludes:['system/js/index','system/util/mpVueComponent','system/util/mpVuePackage']
//            excludes:['system/util/mpFormBuilder','system/js/index','system/util/mpVueComponent','system/util/mpVuePackage']
        }
    });
</script>
<script type="text/javascript" src="/public/system/util/mpFrame.js"></script>
    
</head>
<body class="gray-bg">
<!--演示地址https://daneden.github.io/animate.css/?-->
<div class="wrapper wrapper-content animated ">

<div class="layui-fluid">
    <div class="layui-row layui-col-space15"  id="app">
        <div class="layui-col-md6 layui-col-sm6">
            <div class="layui-card">
                <div class="layui-card-header">总佣金排名</div>
                <div class="layui-card-body">
                    <table class="layui-table layuiadmin-page-table" lay-skin="line">
                        <thead>
                        <tr>
                            <th>排名</th>
                            <th>昵称/手机号</th>
                            <th>收入佣金</th>
                            <th>佣金余额</th>
                        </tr>
                        </thead>
                        <tbody v-cloak="">
                        <tr v-for="(item,index) in pointList">
                            <td>{{page==1 ?index+1:(index+1)+(page-1)*limit}}</td>
                            <td>{{item.real_name}}</td>
                            <td>{{item.extract_price}}</td>
                            <td>{{item.balance}}</td>
                        </tr>
                        <tr v-show="pointList.length<=0" style="text-align: center">
                            <td colspan="4">暂无数据</td>
                        </tr>
                        </tbody>
                    </table>
                    <div ref="page" v-show="count>limit" style="text-align: right;"></div>
                </div>
            </div>
        </div>
        <div class="layui-col-md6 layui-col-sm6">
            <div class="layui-card">
                <div class="layui-card-header">本月佣金排名</div>
                <div class="layui-card-body">
                    <table class="layui-table layuiadmin-page-table" lay-skin="line">
                        <thead>
                        <tr>
                            <th>排名</th>
                            <th>昵称/手机号</th>
                            <th>收入佣金</th>
                            <th>佣金余额</th>
                        </tr>
                        </thead>
                        <tbody v-cloak="">
                        <tr v-for="(item,index) in monthList">
                            <td>{{page==1 ?index+1:(index+1)+(monthpage-1)*limit}}</td>
                            <td>{{item.real_name}}</td>
                            <td>{{item.extract_price}}</td>
                            <td>{{item.balance}}</td>
                        </tr>
                        <tr v-show="monthList.length<=0" style="text-align: center">
                            <td colspan="4">暂无数据</td>
                        </tr>
                        </tbody>
                    </table>
                    <div ref="month_page" v-show="monthcount>limit" style="text-align: right;"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="/public/system/js/layuiList.js"></script>
<script>
    require(['vue'],function(Vue) {
        new Vue({
            el: "#app",
            data: {
                pointList:[],
                monthList:[],
                count:0,
                limit:20,
                page:1,
                monthpage:1,
                monthcount:0
            },
            watch:{
                page:function (n){
                    this.getCommissionList();
                },
                monthpage:function (n) {
                    this.getMonthCommissionList()
                }
            },
            methods:{
                getMonthCommissionList:function(){
                    var that=this;
                    layList.baseGet(layList.U({a:'getMonthCommissionList',p:{page:this.page,limit:this.limit}}),function (rem) {
                        that.monthList=rem.data;
                    });
                },
                getCommissionList:function (){
                    var that=this;
                    var index=layList.layer.load(2,{shade: [0.3,'#fff']});
                    layList.baseGet(layList.U({a:'getCommissionList',p:{limit:this.limit,page:this.page}}),function (rem) {
                        layList.layer.close(index);
                        that.pointList=rem.data;
                    },function () {
                        layList.layer.close(index);
                    });
                }
            },
            mounted:function () {
                var that=this;
                this.getCommissionList();
                this.getMonthCommissionList();
                layList.baseGet(layList.U({a:'getCommissonCount'}),function (rem) {
                    that.count=rem.data;
                    layList.laypage.render({
                        elem: that.$refs.month_page
                        ,count:that.count
                        ,limit:that.limit
                        ,theme: '#1E9FFF',
                        jump:function(obj){
                            that.page=obj.curr;
                        }
                    });
                });
                layList.baseGet(layList.U({a:'getMonthCommissonCount'}),function (rem) {
                    that.count=rem.data;
                    layList.laypage.render({
                        elem: that.$refs.page
                        ,count:that.monthcount
                        ,limit:that.limit
                        ,theme: '#1E9FFF',
                        jump:function(obj){
                            that.monthpage=obj.curr;
                        }
                    });
                });
            }
        })
    })
</script>




</div>
</body>
</html>
