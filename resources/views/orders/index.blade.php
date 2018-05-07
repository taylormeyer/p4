@extends('layouts.app')

@push('styles')
{{-- Data table --}}
<link href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap4.min.css" rel="stylesheet">
@endpush

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    My Orders
                    <a href="{{ "orders/create" }}" class="btn btn-info pull-right ">Add Order</a>
                </div>

                <div class="card-body">
                    
                    <table id="logoDatatable" class="table table-striped table-bordered" style="width: 100%;border-collapse: collapse !important;">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Description</th>
                                <th>Order #</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Description</th>
                                <th>Order #</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')

{{-- Data table --}}
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script>

<script type="text/javascript">

$(document).ready(function() {
    var orderTable = $('#logoDatatable').DataTable({
            "dom": '<"row" <"col-sm-4"l> <"col-sm-4"r> <"col-sm-4"f>> <"row"  <"col-sm-12"t>> <"row" <"col-sm-5"i> <"col-sm-7"p>>',
            processing: true,
            serverSide: true,
            responsive: true,
            pagingType: "full_numbers",
            "ajax": {
                "url": "{!! 'orders/datatable' !!}"
            },
            columns: [
                { data: 'DT_Row_Index', searchable: false, orderable:false, width: "100" },
                { data: 'description', name: 'description'},
                {
                    data:  "formated_order_id",
                    name:  "id",
                    orderable: false,
                    searchable: false,
                    width:"100",
                    render:function(o){
                        return o;
                    }
                },
                { data: 'order_time', name: 'order_time'},
                {
                    data:  null,
                    "orderable": false,
                    "searchable": false,
                    width:"100",
                    "render":function(o){
                        var str="";

                        str +="<a href='{{ url('orders') }}/" + o.id + "'>View</a> ";
                        str +="<a href='{{ url('orders') }}/" + o.id + "/edit'>Edit</a> ";
                        str += "<a href='javascript:void(0);' class='deleteRecord' data-val='" + o.id + "'>Delete</a> ";
                        
                        return str;
                    }
                }
            ],
            order: [["2"]]
    });

    $(document).on("click", ".deleteRecord", function() {
        var orderId = $(this).data("val") || '';
        if(orderId != "") {
            $(".alert").hide();
            if (confirm('Are you sure you want to delete this order?')) {
                jQuery.ajax({
                    url: "{{url("orders")}}/"+orderId,
                    type: 'DELETE',
                    dataType: 'json',
                    data: {
                        "_token": "{{csrf_token()}}"
                    },
                    success: function (result) {
                        orderTable.draw();
                        $("#header-show-success-title").text(result.message).show();
                    },
                    error: function (xhr, status, error) {
                        var msg = "Something went wrong";
                        if(xhr.responseJSON && xhr.responseJSON.message!=""){
                            msg = xhr.responseJSON.message;
                        }
                        $("#header-show-error-title").text(msg).show();
                    }
                }); 
            }
        }
    });

});

</script>
@endpush