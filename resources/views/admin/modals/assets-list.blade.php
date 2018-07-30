@foreach ($assets as $a)
<div class="file" data-id="{{$a->id}}" style="background-image: url({{url($a->mime_path)}})"></div>
@endforeach