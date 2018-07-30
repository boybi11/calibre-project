<?php $i = 0; ?>
@foreach ($columns as $c)
<?php 
	$column = str_replace('_', ' ', ucfirst($c));
?>
@if ($i > 0)
            <th>{{$column}}</th>
@else
<th>{{$column}}</th>
@endif
<?php $i++; ?>
@endforeach