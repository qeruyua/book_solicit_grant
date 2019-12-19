@extends('layouts.app')
@section('content')
    <form action="/indicator/saveData" method="post">
        @csrf

        <input  type="hidden" name="date" value="{{ $date }}">

        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead class=" text-primary">
                    <th  style="color: #009688">英文名</th>
                    <th  style="color: #009688">中文名</th>
                    <th style="color: #009688">下限</th>
                    <th style="color: #009688">上限</th>
                    <th style="color: #009688">值</th>
                    <th  style="color: #009688" class="text-right">单位</th>
                    </thead>
                    <tbody>



                    <tr>
                    @foreach($indicators as $indicator)
                        <tr>
                            <td  class="tableInp"><input style="width: 100%" type="text" name="{{ $indicator->id }}[name_en]" value="{{ $indicator->name_en }}"></td>
                            <td class="tableInp" ><input  style="width: 100%" type="text" name="{{ $indicator->id }}[name_ch]" value="{{ $indicator->name_ch }}"></td>
                            <td class="tableInp" ><input style="width: 100%" type="text" name="{{ $indicator->id }}[lower_limit]" value="{{ $indicator->lower_limit }}"></td>
                            <td class="tableInp" ><input  style="width: 100%" type="text" name="{{ $indicator->id }}[upper_limit]" value="{{ $indicator->upper_limit }}"></td>
                            <td class="tableInp" ><input  style="width: 100%" type="text" name="{{ $indicator->id }}[value]" value="{{ $indicator->value }}"></td>
                            <td  class="text-right tableInp"><input  style="width: 100%" type="text" name="{{ $indicator->id }}[unit]" value="{{ $indicator->unit }}"></td>
                        </tr>

                        @endforeach
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div align="center" style="margin-bottom: 20px">
        <button class="layui-btn" lay-submit="" lay-filter="demo1">确认信息</button>
        </div>
    </form>


@endsection