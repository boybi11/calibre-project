<table class='table table-striped table-bordered'>
	<tr>
		<th>Name</th>
		<td>{{$data->name}}</td>
	</tr>
	<tr>
		<th>Slug</th>
		<td>{{$data->slug}}</td>
	</tr>
	<tr>
		<th>Integer</th>
		<td>{{$data->integer}}</td>
	</tr>
</table>
<a href='{{route("adminTestsView", [$data->id])}}' class='btn btn-primary'>More Details</a>