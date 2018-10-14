<table class='table table-striped table-bordered'>
	<tr>
		<th>Name</th>
		<td>{{$sample->name}}</td>
	</tr>
	<tr>
		<th>Range</th>
		<td>{{$sample->range}}</td>
	</tr>
	<tr>
		<th>Runes</th>
		<td>{{$sample->runes}}</td>
	</tr>
	<tr>
		<th>Embedded Rune</th>
		<td>{{$sample->embedded_rune}}</td>
	</tr>
	<tr>
		<th>Evaluation</th>
		<td>{{$sample->evaluation}}</td>
	</tr>
</table>
<a href='{{route("adminSamplesView", [$sample->id])}}' class='btn btn-primary'>All Details</a>