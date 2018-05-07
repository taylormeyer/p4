@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    Edit Order
                </div>

                <div class="card-body">
                    
                    {!! Form::model($order, array('url' =>'orders/'.$order->id, 'method' => 'PUT', 'class'=>'form-horizontal','id'=>'form_validate', 'autocomplete'=>'off')) !!}
                    	@include("orders._form")
                    {!! Form::close() !!}

                </div>
            </div>
        </div>
    </div>
</div>

@endsection
