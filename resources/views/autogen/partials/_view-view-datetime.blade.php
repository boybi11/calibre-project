		<tr>
			<th>{$PLACEHOLDER}</th>
			<td>
				@if ($data->{$NAME})
				<?php $created_at = new Carbon($data->{$NAME}); ?>
				{{$created_at->toFormattedDateString() . ' ' . $created_at->toTimeString()}}
				@endif
			</td>
		</tr>
