@extends('layouts.admin')
@section('title')
    Bảng Tổng Hợp
@endsection
@section('breadcrumb')
    Bảng Tổng Hợp
@endsection
@section('css')
    <link href="{{asset('admin/assets/datatables/plugins/bootstrap/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css"/>
@endsection
@section('js')
    <script>
        var urlList = '{{route('admin.report.findData')}}';
        var urlDate = '{{route('admin.report.findDataByDate')}}'
    </script>
@endsection
@section('js-top')
    <!-- data table -->
    <script src="{{asset('admin/assets/datatables/jquery.dataTables.min.js')}}" ></script>
    <script src="{{asset('admin/assets/datatables/plugins/bootstrap/dataTables.bootstrap4.min.js')}}" ></script>
    <script src="{{asset('admin/js/datatable-init.js')}}" ></script>
    <!-- chart js -->
    <script src="{{asset('admin/assets/chart-js/Chart.bundle.js')}}" ></script>
    <script src="{{asset('admin/assets/chart-js/utils.js')}}" ></script>
@endsection
@section('content')
    <!-- start widget -->
    <div class="row">
        <div class="col-md-12">
            <div class="card card-topline-red">
                <div class="card-body no-padding height-9">
                    <div class="row">
                        <div class="col-md-4">
                            <label>Xem theo tháng</label>
                            <div class="form-group">
                                <select class="form-control input-height" onchange="getByTime('sltTime')" id="sltTime">
                                    @for($i=1;$i<=12;$i++)
                                    <option value="{{$i}}" @if($i == date('m')) selected @endif>Tháng {{$i}}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <label>Xem theo khoảng ngày</label>
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <input type="text" placeholder="Chọn ngày bắt đầu..." onfocus="(this.type='date')" class="form-control" name="f_date" id="f_date">
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <input type="text" placeholder="Chọn ngày kết thúc..." onfocus="(this.type='date')" class="form-control" name="t_date" id="t_date">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <button class="btn btn-primary" onclick="getByDate()"><i class="fa fa-search"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div id="p2" class="mdl-progress mdl-js-progress mdl-progress__indeterminate hidden"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="dashboard-data">
        @include('admin.report.dashboard_data')
    </div>


@endsection