@extends('indicator.head')
@section('record')
    <!-- End Navbar -->
    <div class="panel-header panel-header-sm">
    </div>
    <div class="content">
        <div class="row">
            <div class="col-md-8 ml-auto mr-auto">
                <div class="card card-upgrade" style="padding:30px">
                    <ul class="layui-timeline">
                        @forelse($images as $image)
                            <li class="layui-timeline-item">
                                <i class="layui-icon layui-timeline-axis"></i>
                                <div class="layui-timeline-content layui-text">
                                    <h3 class="layui-timeline-title">{{ $image['created_at'] }}</h3>
                                    <a href="/indicator/delete/{{ $image['id'] }}" class="layui-btn layui-btn-danger layui-timeline-title">删除</a>
                                    <h2 class="layui-timeline-title">{{ $image['type'] }}</h2>
                                    <a href="{{ asset('storage/'.$image['name']) }}"><img src="{{ asset('storage/'.$image['name']) }}" width="200px"></a>
                                </div>
                            </li>
                        @empty
                            <h3>您还未曾上传过图片</h3>
                        @endforelse

                    </ul>
                    {{--<div class="card-header text-center">--}}
                        {{--<h4 class="card-title">上传历史</h4>--}}
                    {{--</div>--}}
                </div>

            </div>
        </div>



    </div>

@endsection