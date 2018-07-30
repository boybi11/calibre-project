<div class="form-group">
  <label for="name">Name</label>
  {!! Form::text('name', null, ['class'=>'form-control', 'id'=>'name', 'placeholder'=>'Name', 'required']) !!}
</div>
<div class="form-group">
  <label for="slug">Slug</label>
  {!! Form::text('slug', null, ['class'=>'form-control', 'id'=>'slug', 'placeholder'=>'Slug', 'required']) !!}
</div>
<div class="form-group sumo-asset-select" data-crop-url="{{route('adminProductsCropUrl')}}">
  <label for="image">Image</label>
  {!! Form::hidden('image', null, ['class'=>'sumo-asset', 'data-id'=>@$data->id, 'data-thumbnail'=>'image_thumbnail']) !!}
</div>
<div class="form-group clearfix">
	<a href="{{route('adminProducts')}}" class="btn btn-default">Back</a>
	<button type="submit" class="btn btn-primary pull-right">
		<i class="fa fa-check" aria-hidden="true"></i>
		Save
	</button>
</div>