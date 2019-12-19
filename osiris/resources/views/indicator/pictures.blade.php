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
                        <h4 class="card-title">智能上传</h4>
                    </div>
                    {{--<form class="card-body" action="/indicator/upload" method="post" id="form">--}}
                    <div class="layui-upload">
                        <button type="button" class="btn btn-primary btn-block layui-btn" style="width: 100px;margin-left: 20px"  id="upload">上传图片</button>
                        <div class="layui-upload-list">
                            <img class="layui-upload-img" id="demo1">
                            <p id="demoText"></p>
                        </div>
                    </div>
                    <form class="layui-form" action="/ocr/" method="post" id="form">
                        @csrf

                        <input  class="form-control"  required name="type" id="wlmsinput" name="type"   placeholder="请输入您的检查名称"  list="wlmslist" />
                        <datalist id="wlmslist"  lay-verify="">
                            <option  v-for="(item,i) in list" >@{{item}}</option>
                        </datalist>



                        <br>
                        <div class="layui-inline">
                            <label class="layui-form-label">日期</label>
                            <div class="layui-input-inline">
                                <input type="text" required class="layui-input" id="test5" placeholder="检查的时间" name="date">

                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">智能匹配</label>
                            <div class="layui-input-block">
                                <input type="checkbox"  name="is_memory" lay-skin="switch" lay-filter="switchTest" lay-text="开|关">
                            </div>
                        </div>
                        <input type="submit" style="margin-top: 30px" class="btn btn-primary btn-block"  id='submit'  value="确定" onclick="load()" disabled>
                    </form>



                    {{--</form>--}}
                </div>

                {{--<div class="card card-upgrade">--}}
                    {{--<div class="card-header text-center">--}}
                        {{--<h4 class="card-title">上传历史</h4>--}}
                    {{--</div>--}}
                    {{--<form class="card-body" action="/indicator/upload" method="post" id="form">--}}
                    {{--<ul class="layui-timeline">--}}
                        {{--@foreach($images as $image)--}}
                            {{--<li class="layui-timeline-item">--}}
                                {{--<i class="layui-icon layui-timeline-axis"></i>--}}
                                {{--<div class="layui-timeline-content layui-text">--}}
                                    {{--<h3 class="layui-timeline-title">{{ $image['created_at'] }}</h3>--}}
                                    {{--<a href="/indicator/delete/{{ $image['id'] }}" class="layui-btn layui-btn-danger layui-timeline-title">删除</a>--}}
                                    {{--<h2 class="layui-timeline-title">{{ $image['type'] }}</h2>--}}
                                    {{--<a href="{{ asset('storage/'.$image['name']) }}"><img src="{{ asset('storage/'.$image['name']) }}" width="200px"></a>--}}
                                {{--</div>--}}
                            {{--</li>--}}
                        {{--@endforeach--}}
                    {{--</ul>--}}

                    {{--</form>--}}
                {{--</div>--}}

            </div>
        </div>



    </div>
    <script>
        var vm=new Vue({
            el:'#wlmslist',
            data:{
                list:['甲状腺功能','肝功','血常规']
            },
            methods:{
                gernerateId: function (i){
                    return "container" + i;

                },

            },
        });



        layui.use('form', function(){
            var form = layui.form; //只有执行了这一步，部分表单元素才会自动修饰成功
            form.render();
            form.on('switch(switchTest)', function(data){
//                layer.msg('开关checked：'+ (this.checked ? 'true' : 'false'), {
//                    offset: '6px'
//                });
                layer.tips('如之前提交过相同格式的病例单请勾选此项，否则请勿勾选', data.othis)
            });
        });
        function load() {
            layer.open({
                type:3,
                //icon: 16,
                shadeClose:false,
                content:'识别中',
                closeBtn: 0
            });
        }
        layui.use('upload', function(){
            var $ = layui.jquery
                ,upload = layui.upload;

            //普通图片上传
            var uploadInst = upload.render({
                elem: '#upload'
                ,field: 'image'
                ,url: '/indicator/upload'
                , headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                }
                ,before: function(obj){
                    //预读本地文件示例，不支持ie8
                    obj.preview(function(index, file, result){
                        $('#demo1').attr('src', result);
                    });
                }
                ,done: function(res, index, upload){
                    //如果上传失败
                    if(res.id == 0){
                        return layer.msg('上传失败');
                    }
                    if(res.id){
                        layer.msg('上传成功');
                        var form = document.getElementById('form');
                        var imageId = document.createElement("input");
                        imageId.type = "hidden";
                        imageId.name = 'image_id';
                        imageId.value = res.id;
                        form.appendChild(imageId);
                        var subtn = document.getElementById('submit');
                        subtn.disabled = false;
                    }
                }
                ,error: function(){
                    //演示失败状态，并实现重传
                    var demoText = $('#demoText');
                    demoText.html('<span style="color: #FF5722;">上传失败</span> <a class="layui-btn layui-btn-xs demo-reload">重试</a>');
                    demoText.find('.demo-reload').on('click', function(){
                        uploadInst.upload();
                    });
                }
            });
        });
        layui.use('laydate', function() {
            var laydate = layui.laydate;

            laydate.render({
                elem: '#test5'
                ,type: 'datetime'
            });
        });
    </script>
@endsection