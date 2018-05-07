
@push('styles')
<link href="{{ asset('plugins/jquery-datetimepicker/jquery.datetimepicker.min.css') }}" rel="stylesheet">
@endpush

@foreach($menuItems as $key => $menuitem)
    <div class="form-group {{ ($errors->first("quantity.$menuitem->id")) ? 'has-error' :'' }} " style="border-bottom: 1px solid; margin-bottom: 20px;">
        <div class="col-sm-12">
            <h4>{{ $menuitem->name }}</h4>
            <span>{{ $menuitem->description }}</span>
            <p>
                <strong> ${{ $menuitem->price.' '. $menuitem->unit }} </strong>
                {{ Form::text("quantity[$menuitem->id]", (isset($orderQtyList[$menuitem->id])) ? $orderQtyList[$menuitem->id] : 0, ['class'=>'']) }}
            </p>
            @if($errors->has("quantity.$menuitem->id"))
                <span class="help-block m-b-none">{{ $errors->first("quantity.$menuitem->id") }}</span>
            @endif
        </div>
    </div>
@endforeach


<div class="form-group {{ ($errors->first('order_time')) ? 'has-error' :'' }} ">
    <label class="col-sm-2 control-label">Order Time</label>
    <div class="col-sm-10">
        {{ Form::text('order_time', null, ['class'=>"form-control", "id"=>"order_time"]) }}
        @if($errors->has('order_time'))
            <span class="help-block m-b-none">{{ $errors->first('order_time') }}</span>
        @endif
    </div>
</div>

<div class="form-group {{ ($errors->first('description')) ? 'has-error' :'' }} ">
    <label class="col-sm-2 control-label">Description</label>
    <div class="col-sm-10">
        {{ Form::textarea('description', null, ['class'=>"form-control"]) }}
        @if($errors->has('description'))
            <span class="help-block m-b-none">{{ $errors->first('description') }}</span>
        @endif
    </div>
</div>

<div class="form-group">
    <div class="col-sm-10 referral_ftrbtn category_ftrbtn">
    {{ Form::submit('Place My Order', ['class'=>'btn btn-primary']) }}
    <a href="{{ url('orders') }}" class="btn btn-danger">Cancel</a>
    </div>
</div>

@push('scripts')
<script src="{{ asset('plugins/jquery-datetimepicker/jquery.datetimepicker.full.min.js') }}"></script>

<script>
    $(document).ready(function () {
        $('#order_time').datetimepicker({
        });
    });
</script>
@endpush
