@extends('layouts.app')

@push('styles')
@endpush

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    View Order
                </div>

                <div class="card-body order-details">
                    <div class="row">
                        <div class="col-md-12">
                            <a class="btn btn-info pull-right" href="{{url('orders')}}">Back</a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 order-lable">Order ID:</div>
                        <div class="col-md-9">{{ $order->formated_order_id }}</div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 order-lable">Order Description:</div>
                        <div class="col-md-9">{{ $order->description }}</div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 order-lable">Order Date:</div>
                        <div class="col-md-9">{{ $order->order_time }}</div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 order-lable">Order Items:</div>
                        <div class="col-md-9">
                            @if(count($orderItems))
                                <table class="table">
                                    <thead>
                                        <th>Item</th>
                                        <th>Quantity</th>
                                        <th>Price</th>
                                        <th>Total Amount</th>
                                    </thead>
                                    <tbody>
                                        @php $totalAmount = 0; @endphp
                                        @foreach($orderItems as $orderItem)
                                            <tr>
                                                <td>{{ $orderItem->menuItem->name }}</td>
                                                <td>{{  $orderItem->quantity }}</td>
                                                <td>${{ number_format( $orderItem->menuItem->price, 2 ) }}</td>
                                                <td>${{ number_format( ( $orderItem->menuItem->price * $orderItem->quantity ), 2) }}</td>
                                            </tr>
                                            @php $totalAmount += ( $orderItem->menuItem->price * $orderItem->quantity ) ; @endphp
                                        @endforeach 
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="3">Total Amount</th>
                                            <th>${{ number_format( $totalAmount, 2) }}</th>
                                        </tr>
                                    </tfoot>
                                </table> 
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection
