<div class="form-group sumo-asset-select" data-crop-url="{{route('admin{$ROUTE_NAME}CropUrl')}}">
  <label for="{$NAME}">{$PLACEHOLDER}</label>
  {!! Form::hidden('{$NAME}', null, ['class'=>'sumo-asset', 'data-id'=>@$data->id, 'data-thumbnail'=>'{$NAME}_thumbnail']) !!}
</div>
