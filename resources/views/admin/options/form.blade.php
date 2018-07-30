<div class="options-form">
	<div class="form-group">
	  <label for="name">Name</label>
	  {!! Form::text('name', null, ['class'=>'form-control', 'id'=>'name', 'placeholder'=>'Name']) !!}
	</div>
	<div class="form-group">
	  <label for="slug">Slug</label>
	  {!! Form::text('slug', null, ['class'=>'form-control', 'id'=>'slug', 'placeholder'=>'Slug']) !!}
	</div>
	<div class="form-group">
	  <label for="type">Type</label>
	  {!! Form::select('type', ['text' => 'text', 'asset' => 'asset'], null, ['id'=>'option-type', 'class'=>'form-control']) !!}
	</div>
	<div class="form-group option-type option-type-text hide">
	  <label for="value">Value</label>
	  {!! Form::textarea('value', null, ['class'=>'form-control', 'id'=>'value', 'placeholder'=>'Value']) !!}
	</div>
	<div class="form-group option-type option-type-asset hide sumo-asset-select">
		<label for="asset">Asset</label>
		{!! Form::hidden('asset', null, ['class'=>'sumo-asset']) !!}
	</div>
	<div class="form-group clearfix">
		<a href="{{route('adminOptions')}}" class="btn btn-default">Back</a>
    <button type="submit" class="btn btn-primary pull-right">
      <i class="fa fa-check" aria-hidden="true"></i>
      Save
    </button>
  </div>
</div>