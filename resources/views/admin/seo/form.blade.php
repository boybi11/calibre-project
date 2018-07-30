<div class="col-sm-4">
  <div class="widget">
    <div class="header">
      <i class="fa fa-globe"></i> SEO
    </div>
  </div>
  {!! Form::model($seo, ['route'=>['adminSamplesSeo'], 'class'=>'form form-seo']) !!}
  <div class="form-group">
    <label for="name">Title</label>
    {!! Form::text('title', null, ['class'=>'form-control', 'id'=>'title', 'placeholder'=>'Title']) !!}
    {!! Form::hidden('seoable_id', $data->id) !!}
    {!! Form::hidden('seoable_type', get_class($data)) !!}
  </div>
  <div class="form-group">
    <label for="evaluation">Description</label>
    {!! Form::textarea('description', null, ['class'=>'form-control', 'id'=>'description', 'placeholder'=>'Description']) !!}
  </div>
  <div class="form-group sumo-asset-select">
    <label for="image">Image</label>
    {!! Form::hidden('image', null, ['class'=>'sumo-asset']) !!}
  </div>
  <div class="form-group clearfix">
    <button type="submit" class="btn btn-primary pull-right">
      <i class="fa fa-check" aria-hidden="true"></i>
      Save
    </button>
  </div>
  {!! Form::close() !!}
</div>