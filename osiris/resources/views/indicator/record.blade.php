@extends('indicator.head')
@section('record')
    <!-- End Navbar -->
    <div class="panel-header panel-header-lg" style="height: 100px">
        <canvas id="bigDashboardChart"></canvas>
    </div>
    <div class="content" id="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-chart layui-anim layui-anim-up"  v-for="(item,i) in data1" >
                    <div class="card-header">
                        <div class="dropdown"  style="margin-top: -12px">
                            <button   :id="getId(i)"   @click="dange(i)" title="异常" type="button" class="btn btn-danger btn-round btn-default dropdown-toggle btn-simple btn-icon no-caret" >
                                <i class="now-ui-icons gestures_tap-01"></i>
                            </button>
                            <button  :id="getSId(i)"    title="健康" type="button" class="btn btn-success btn-round btn-default dropdown-toggle btn-simple btn-icon no-caret" >
                                <i class="now-ui-icons emoticons_satisfied"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="chart-area">
                            <div class="container"  :id="gernerateId(i)" style="height: 100%"></div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        var data;
        var resultMsg=new Array();
        var vm=new Vue({
            el: '#content',
            data: {
                data1: '',
            },
            methods: {

                gernerateId: function (i) {
                    return "container" + i;

                },
                getSId: function (i) {
                    return "safeBut" + i;
                },
                getId: function (i) {
                    return "but" + i;

                },
                dange: function (i) {
                    console.log(resultMsg)
                    var t = resultMsg[i];
                    var q = {
                        badder: [],
                        better: [{name: "促甲状腺激素", status: "高"}, {name: "游离甲状腺素", status: "高"}, {
                            name: "游离三碘甲状腺原氨酸",
                            status: "高"
                        }
                        ],
                        unbiased:[]
                    };
                    var string1 = '';
                    for (var j = 0; j < t.badder.length; j++) {
                        var con = t.badder[j];
                        string1 = string1 + "<div style='font-size: 1.2em;line-height: 1.8em'>您的<button  data-method=\"setTop\" class=\"likeA\"  onclick=show(\"" + con.name + "\",\"" + con.status + "\") style=''>" + con.name + "</button>指标偏" + con.status + "更<strong>严重</strong>了</div>"
                    }
                    for (var k = 0; k < t.better.length; k++) {
                        var con = t.better[k];
                        string1 = string1 + "<div  style='font-size: 1.2em;line-height: 1.8em'>您的<button  data-method=\"setTop\" class=\"likeA\" onclick=show(\"" + con.name + "\",\"" + con.status + "\") style=''>" + con.name + "</button>指标偏有所好转，但仍然偏" + con.status + "</div>"
                    }
                    for (var ij = 0; ij < t.unbiased.length; ij++) {
                        var con = t.unbiased[ij];
                        string1 = string1 + "<div  style='font-size: 1.2em;line-height: 1.8em'>您的<button  data-method=\"setTop\" class=\"likeA\" onclick=show(\"" + con.name + "\",\"" + con.status + "\") style=''>" + con.name + "</button>指标仍然偏" + con.status + ",近期没有变化</div>"
                    }
                    layui.use('layer', function () {
                        var layer = layui.layer;
                        layer.open({
                            title: "健康提示"
                            , skin: 'demo-class'
                            , area: ['400px', '280px']
                            , content: string1
                            , zIndex: layer.zIndex //重点1
                            , tipsMore: true
                            , success: function (layero) {
                                layer.setTop(layero); //重点2
                            }
                        });


                    });
                }

            },
            created: function () {
                var that = this;
                this.$http.get('/indicator/show/user/{{ $user['id'] }}').then(function (result) {
                    var arr2 = Object.keys(result.body);
                    this.data1 = arr2;
                });

            },
        })
        function check(data) {
            if (data.length == 2) {
                var find = false;
                var better = [];
                var bader = [];
                var unbiased  = [];
                for (var i = 0; i < data[0].length; i++) {
                    find = false;
                    for (var j = 0; j < data[1].length; j++) {
                        if (data[0][i]['name_ch'] == data[1][j]['name_ch']) {
                            var res = {name: data[0][i]['name_ch']};
                            if (Math.min(data[0][i]['u_abs'], data[0][i]['l_abs']) > Math.min(data[1][j]['u_abs'], data[1][j]['l_abs'])) {
                                // 恶化
                                console.log(data[0][i]);
                                if (data[0][i]['u_abs'] > data[0][i]['l_abs']) {
                                    res.status = '低';
                                } else {
                                    res.status = '高';
                                }
                                bader.push(res);
                            } else if (Math.min(data[0][i]['u_abs'], data[0][i]['l_abs']) < Math.min(data[1][j]['u_abs'], data[1][j]['l_abs'])) {
                                console.log(data[0][i]);
                                // 好转
                                if (data[0][i]['u_abs'] > data[0][i]['l_abs']) {
                                    res.status = '低';
                                } else {
                                    res.status = '高';
                                }
                                better.push(res);
                            }else{
                                if (data[0][i]['u_abs'] > data[0][i]['l_abs']) {
                                    res.status = '低';
                                } else {
                                    res.status = '高';
                                }
                                unbiased.push(res);
                            }
                            data[1].splice(j, 1);
                            find = true;
                            break;
                        }

                    }

                    if (!find) {
                        var res = {name: data[0][i]['name_ch']};
                        if (data[0][i]['u_abs'] > data[0][i]['l_abs']) {
                            res.status = '低';
                        } else {
                            res.status = '高';
                        }
                        bader.push(res);
                    }
                }
                for (var j = 0; j < data[1].length; j++) {
                    var res = {name: data[1][j]['name_ch']};
                    if (data[1][j]['u_abs'] > data[1][j]['l_abs']) {
                        res.status = '低';
                    } else {
                        res.status = '高';
                    }
                    better.push(res);
                }
            }
            return {better: better, badder: bader, unbiased:unbiased}
        }
        function show(i,status) {
            var t;
           // console.log(resultMsg)
            $.ajax({url:'/api/detail/'+i,success:function(result){
                console.log(result)
                t=result;
                console.log(t)
                if(t==''||!t)
                {
                    layer.open({
                        type: 1,
                        title: i,
                        content:"<h4 style='font-size: 1.2em;line-height: 1.8em'>啊哦，暂时还没有这个指标的相关数据呢,为您推荐相关资料如下:</h4><ul><li style='font-size: 1.2em;line-height: 1.8em'><a target='_blank' style='color: #0d6aad' href='http://www.a-hospital.com/w/"+i+"'>医学百科<strong>"+i+"</strong>相关资料</a></li><li style='font-size: 1.2em;line-height: 1.8em'><a target='_blank' style='color: #0d6aad' href='https://www.uptodate.com/contents/"+i+"'>UpToDate临床顾问<strong>"+i+"</strong>相关资料</a></li></ul>"
                        ,skin: 'demo-class'
                        ,area: ['450px', '260px']
                        ,tipsMore: true
                        ,zIndex: layer.zIndex //重点1
                        ,success: function(layero){
                            layer.setTop(layero); //重点2
                        }

                    })
                }
                else
                {
                    var ill='';
            if(status=="高"){
                ill=t.high
            }
            else if(status=="低")
            {
                ill=t.low
            }
            var string1="<div  style='font-size: 1.2em;line-height: 1.8em'>"+i+"("+t.name_en+"):"+t.desc+"。</div><div>过"+status+"可能与<strong>"+ill+"</strong>等疾病有关，身体健康无小事建议及时就医</div><div style='margin-top: 5px;position: absolute;bottom: 10px;right: 10px'>资料来源于<strong><a target='_blank' href='http://www.a-hospital.com' >医学百科</a></strong>&nbsp;<a target='_blank' style='color: #0d6aad' href='http://www.a-hospital.com/w/"+i+"'>点击查看原始信息</a></div>";
            layer.open({
                type: 1,
                title: i,
                content:string1
                ,skin: 'demo-class'
                ,area: ['450px', '260px']
                ,tipsMore: true
                ,zIndex: layer.zIndex //重点1
                ,success: function(layero){
                    layer.setTop(layero); //重点2
                }

            });

                }
            }});

        }
        function showJson(){
            var test;
            if(window.XMLHttpRequest){
                test = new XMLHttpRequest();
            }else if(window.ActiveXObject){
                test = new window.ActiveXObject();
            }else{
                alert("请升级至最新版本的浏览器");
            }
            if(test !=null){
                test.open("GET","/indicator/show/user/{{ $user['id'] }}",true);
                test.send(null);
                test.onreadystatechange=function(){
                    if(test.readyState==4&&test.status==200){
                        data = JSON.parse(test.responseText);
                        var times=0;
                        for(key in data){
                            var id="container"+times;
                            picture(key,id);
                            times++;

                        }
                    }
                };

            }
        }
        showJson();
        function picture(key,id) {
var num=id.slice(9);
            $.ajax({url:"/warning/info/"+key,success:function(result){
                if(result[0].length!=0||result[1].length!=0)
                {
                    document.getElementById("but"+num).style.display='block';
                    document.getElementById("safeBut"+num).style.display='none';
                    resultMsg[num]=check(result)
                    console.log(resultMsg[num]);
                }
                else {
                    document.getElementById("but"+num).style.display='none';
                    document.getElementById("safeBut"+num).style.display='block';
                    resultMsg[num]=''
                }

            }});




            var dom = document.getElementById(id);
            var myChart = echarts.init(dom);
            var indictors = new Array();
            var indictorsMap= new Map();
            var timeArray = new Array();
            for (var image in data[key]){
                timeArray.push(data[key][image]['created_at']);
                for (var indictor in data[key][image]['indicators']){
                    indictors.push(data[key][image]['indicators'][indictor]['name_ch']);
                }
            }


            indictors = new Set(indictors);
            for (var indictor of indictors){
                for (var image in data[key]){
                    for (var indic in data[key][image]['indicators']){
                        if (data[key][image]['indicators'][indic]['name_ch']==indictor){
                            if(indictorsMap.has(indictor)){
                                indictorsMap.get(indictor).push(data[key][image]['indicators'][indic]['value']);
                            }else {
                                indictorsMap.set(indictor,[]);
                                indictorsMap.get(indictor).push(data[key][image]['indicators'][indic]['value']);
                            }
                        }

                    }
                }
            }
            var seriesObject = mapToObject(indictorsMap);
            var app = {};
            option = null;
            option = {
                title: {
                    text: key,
                    subtext: ''
                },
                tooltip: {
                    trigger: 'axis'
                },
                legend: {
                    data: Array.from(indictors),
                    type:'scroll',
                    left: '50px'
                },
                toolbox: {
                    show: false,
                    feature: {
                        mark: {show: true},
                        dataView: {show: true, readOnly: false},
                        magicType: {show: true, type: ['line', 'bar']},
                        restore: {show: true},
                        saveAsImage: {show: true}
                    }
                },
                calculable: true,
                xAxis: [
                    {
                        type: 'category',
                        boundaryGap: false,
                        data: timeArray
                    }
                ],
                yAxis: [
                    {
                        type: 'value',
                        axisLabel: {
                            formatter: '{value}'
                        }
                    }
                ],
                series: seriesObject
            };

            ;
            if (option && typeof option === "object") {
                myChart.setOption(option, true);
            }
        }
        function mapToObject(indictors) {
            var series = new Array();
            for (var name of indictors){
                series.push({
                    name: name[0],
                    type: 'line',
                    data: name[1],
                });
            }
            return series;
        }
    </script>
@endsection