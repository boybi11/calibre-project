<div class="form-group">
  <label for="{$NAME}">{$PLACEHOLDER}</label>
  {!! Form::select('{$NAME}', [{$OPTIONS}], null, ['class'=>'form-control select2']) !!}
</div>
