<?php $i = 0; ?>
@foreach ($columns as $c)
@if ($i > 0)
            <td><?php echo '{{$d->' . $c . '}}'; ?></td>
@else
<td><?php echo '{{$d->' . $c . '}}'; ?></td>
@endif
<?php $i++; ?>
@endforeach