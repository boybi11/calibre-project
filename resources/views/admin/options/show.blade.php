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
		<th>Type</th>
		<td>{{$data->type}}</td>
	</tr>
	<tr>
		<th>Value</th>
		<td>{{$data->value}}</td>
	</tr>
	<tr>
		<th>Asset</th>
		<td>{{$data->asset}}</td>
	</tr>
	</table>
<a href='{{route("adminOptionsView", [$data->id])}}' class='btn btn-primary'>More Details</a>