<div class="form-group">
  <label for="name">Name</label>
  {!! Form::text('name', null, ['class'=>'form-control', 'id'=>'name', 'placeholder'=>'Name', 'required']) !!}
</div>
<div class="form-group">
  <label for="slug">Slug</label>
  {!! Form::text('slug', null, ['class'=>'form-control', 'id'=>'slug', 'placeholder'=>'Slug', 'required']) !!}
</div>
<div class="form-group">
  <label for="integer">Integer</label>
  {!! Form::text('integer', null, ['class'=>'form-control', 'id'=>'integer', 'placeholder'=>'Integer', 'required']) !!}
</div>
<div class="form-group sumo-asset-select" data-crop-url="{{route('adminTestsCropUrl')}}">
  <label for="image">Image</label>
  {!! Form::hidden('image', null, ['class'=>'sumo-asset', 'data-id'=>@$data->id, 'data-thumbnail'=>'image_thumbnail']) !!}
</div>
<div class="form-group">
  <label for="enum">Enum</label>
  {!! Form::select('enum', ['one' => 'one', 'two' => 'two'], null, ['class'=>'form-control select2']) !!}
</div>
<div class="form-group">
  <label for="text">Text</label>
  {!! Form::textarea('text', null, ['class'=>'form-control', 'id'=>'text', 'placeholder'=>'Text']) !!}
</div>
<div class="form-group clearfix">
	<a href="{{route('adminTests')}}" class="btn btn-default">Back</a>
	<button type="submit" class="btn btn-primary pull-right">
		<i class="fa fa-check" aria-hidden="true"></i>
		Save
	</button>
</div>