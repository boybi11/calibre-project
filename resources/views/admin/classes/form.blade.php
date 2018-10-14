<div class="form-group">
  <label for="name">Name</label>
  {!! Form::text('name', null, ['class'=>'form-control', 'id'=>'name', 'placeholder'=>'Name', 'required']) !!}
</div>
<div class="form-group">
  <label for="embedded_rune">Game master</label>
  {!! Form::select('gm_id', $gms, null, ['class'=>'form-control', 'id'=>'gm_id', 'required']) !!}
</div>
<div class="form-group clearfix">
  <a href="{{route('adminClasses')}}" class="btn btn-default">Back</a>
  <button type="submit" class="btn btn-primary pull-right">
    <i class="fa fa-check" aria-hidden="true"></i>
    Save
  </button>
</div>