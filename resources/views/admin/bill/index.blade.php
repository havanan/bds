@extends('layouts.admin')
@section('title') Hóa Đơn @endsection
@section('breadcrumb')
    Danh sách hóa đơn
@endsection
@section('css')
    <link href="{{asset('admin/assets/datatables/plugins/bootstrap/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css"/>
@endsection
@section('js-top')
    <!-- data table -->
    <script src="{{asset('admin/assets/datatables/jquery.dataTables.min.js')}}" ></script>
    <script src="{{asset('admin/assets/datatables/plugins/bootstrap/dataTables.bootstrap4.min.js')}}" ></script>
    <script src="{{asset('admin/js/datatable-init.js')}}" ></script>
@endsection
@section('js')
    <script src="{{asset('admin/js/product.js')}}"></script>
    <!-- data table -->
    <script>
        var urlDelete = '{{route('admin.bill.delete')}}';
        var urlList = '{{route('admin.bill.getList')}}';
        var infoUrl = '{{route('admin.bill.view')}}';
    </script>
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <a href="{{route('admin.product.create')}}" class="btn btn-primary"><i class="fa fa-plus"></i> Tạo mới</a>
            @include('layouts.notification')
            <div class="card card-box">
                <div class="card-body" id="tableBody">
                    @include('admin.bill.table_body')
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade bill-body" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content bill-preview" style="height: 950px !important;">
                <div id="bodyBill"></div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger" data-dismiss="modal"> Đóng</button>
            </div>
        </div>
    </div>
@endsection
