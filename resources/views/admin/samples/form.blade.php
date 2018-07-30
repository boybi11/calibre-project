<div class="form-group">
  <label for="name">Name</label>
  {!! Form::text('name', null, ['class'=>'form-control', 'id'=>'name', 'placeholder'=>'Name', 'required']) !!}
</div>
<div class="form-group">
  <label for="range">Range</label>
  {!! Form::select('range', ['S' => 'Short', 'M' => 'Mid', 'L' => 'Long'], null, ['class'=>'form-control select2']) !!}
</div>
<div class="form-group sumo-asset-select" data-crop-url="{{route('adminSamplesCropUrl')}}">
  <label for="image">Image</label>
  {!! Form::hidden('image', null, ['class'=>'sumo-asset', 'data-id'=>@$data->id, 'data-thumbnail'=>'image_thumbnail']) !!}
</div>
<div class="form-group">
  <label for="runes">Runes</label>
  {!! Form::text('runes', null, ['class'=>'form-control', 'id'=>'runes', 'placeholder'=>'Runes', 'required']) !!}
</div>
<div class="form-group">
  <label for="embedded_rune">Embedded rune</label>
  {!! Form::text('embedded_rune', null, ['class'=>'form-control', 'id'=>'embedded_rune', 'placeholder'=>'Embedded rune', 'required']) !!}
</div>
<div class="form-group">
  <label for="evaluation">Evaluation</label>
  {!! Form::textarea('evaluation', null, ['class'=>'form-control redactor', 'id'=>'evaluation', 'placeholder'=>'Evaluation', 'required', 'data-redactor-upload'=>route('adminAssetsRedactor')]) !!}
</div>
<div class="form-group clearfix">
  <a href="{{route('adminSamples')}}" class="btn btn-default">Back</a>
  <button type="submit" class="btn btn-primary pull-right">
    <i class="fa fa-check" aria-hidden="true"></i>
    Save
  </button>
</div>