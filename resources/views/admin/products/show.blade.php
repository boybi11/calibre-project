<table class='table table-striped table-bordered'>
	<tr>
		<th>Name</th>
		<td>{{$data->name}}</td>
	</tr>
	<tr>
		<th>Slug</th>
		<td>{{$data->slug}}</td>
	</tr>
</table>
<a href='{{route("adminProductsView", [$data->id])}}' class='btn btn-primary'>More Details</a>