@extends('indicator.head')
@section('record')

<!-- End Navbar -->
<div class="panel-header panel-header-sm">
</div>
<div class="content">
    <div class="row">
        <div class="col-md-8 ml-auto mr-auto">
            <div class="card card-upgrade">
                <div class="card-header text-center">
                    <h4 class="card-title">单项指标查询</h4>
                </div>
                {{--<form class="card-body" action="/indicator/upload" method="post" id="form">--}}
                    <form class="layui-form" id="form">
                        @csrf
                        <div class="layui-form-item">
                            <label class="layui-form-label">指标类型</label>
                            <div class="layui-input-block">
                                <select name="interest" lay-filter="aihao" id="indicator">
                                    @foreach($indicators as $indicator)
                                        <option value="{{$indicator}}">{{ $indicator }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        {{--<input class="form-control"  type="text" placeholder="请输入您的检查名称" required name="type">--}}
                        <input type="button" style="margin-top: 30px" class="btn btn-primary btn-block"  onclick="display()" value="确定">
                    </form>

                    {{--</form>--}}
            </div>

            <div class="card card-upgrade">
                <div class="card-header text-right">
                    <div class="dropdown"  style="margin-top: -12px">
                        <button type="button" class="btn btn-round btn-default dropdown-toggle btn-simple btn-icon no-caret" data-toggle="dropdown">
                            <i class="now-ui-icons loader_gear"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right text-right">
                            <a class="dropdown-item" href="#" id="important" onclick="">设为特别关心数据</a>
                        </div>
                    </div>
                    <div align="center">
                        <h2 class="card-title" id="title" ></h2>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                {{--<form class="card-body" ac
                tion="/indicator/upload" method="post" id="form">--}}
                <div class="container"  id="chart" style="height: 300%"></div>
                    </div>
                </div>
                {{--</form>--}}
            </div>

        </div>
    </div>



</div>
<script>
    layui.use('form', function(){
        var form = layui.form; //只有执行了这一步，部分表单元素才会自动修饰成功

        //……

        //但是，如果你的HTML是动态生成的，自动渲染就会失效
        //因此你需要在相应的地方，执行下述方法来手动渲染，跟这类似的还有 element.init();
        form.render();
    });
    function display() {
        var el=document.getElementById("indicator");
        console.log(el.value);
        var indicator = el.value;
        if (window.XMLHttpRequest) {
            req = new XMLHttpRequest();
        } else if (window.ActiveXObject) {
            req = new window.ActiveXObject();
        } else {
            alert("请升级至最新版本的浏览器");
        }
        if (req != null) {
            req.open("GET", "/indicator/show/" + indicator, true);
            req.send(null);
            req.onreadystatechange = function () {
                if (req.readyState == 4 && req.status == 200) {
                    var OneIndicator = JSON.parse(req.responseText);
                    picture(OneIndicator[0]);
                    var important = document.getElementById('important');
                    important.href = '/indicator/important/'+el.value;
                }
            };
    }
    }

    function picture(OneIndicator) {
        id = "chart";
        console.log(OneIndicator);
        var dom = document.getElementById(id);
        var myChart = echarts.init(dom);
        var indictorsData = new Array();
        var timeArray = new Array();
        var app = {};
        for (i in OneIndicator)
        {
            indictorsData.push(OneIndicator[i]['value']);
            timeArray.push(OneIndicator[i]['created_at']);
        }
        console.log(indictorsData);
        console.log(timeArray);
        var title = document.getElementById('title');
        title.innerHTML = OneIndicator[i]['name_ch'];
        var upper = OneIndicator[i]['upper_limit'];
        var lower = OneIndicator[i]['lower_limit'];
        option = null;
        option = {
            title: {
                text: OneIndicator[i]['name_ch'],
                subtext: ''
            },
            tooltip: {
                trigger: 'axis'
            },
            legend: {
                data: [OneIndicator[i]['name_ch']]
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
            series: {
                name: OneIndicator[i]['name_ch'],
                type: 'line',
                data: indictorsData,
                markPoint: {
                    data: [
                        {type: 'max', name: '最大值'},
                        {type: 'min', name: '最小值'}
                    ]
                },
                markLine: {
                    itemStyle: {
                        normal: { lineStyle: { type: 'solid', color: '#ff0002' }, label: { show: true, position: 'end' } },
                    },
                    label:{
                        show: true,
                        position: 'middle'
                    },
                    symbol: ['none', 'none'],
                    data: [
                        {
                            name: '上限',
                            yAxis: upper
                        },
                        {
                            name: '下线',
                            yAxis: lower
                        }

                    ]
                }
            }
        };

        if (option && typeof option === "object") {
            myChart.setOption(option, true);
        }
    }

</script>
@endsection