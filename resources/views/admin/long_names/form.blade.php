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
<div class="form-group">
  <label for="image">Image</label>
  {!! Form::text('image', null, ['class'=>'form-control', 'id'=>'image', 'placeholder'=>'Image']) !!}
</div>
<div class="form-group">
  <label for="thumb">Thumb</label>
  {!! Form::text('thumb', null, ['class'=>'form-control', 'id'=>'thumb', 'placeholder'=>'Thumb']) !!}
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
	<a href="{{route('adminLong_names')}}" class="btn btn-default">Back</a>
	<button type="submit" class="btn btn-primary pull-right">
		<i class="fa fa-check" aria-hidden="true"></i>
		Save
	</button>
</div>