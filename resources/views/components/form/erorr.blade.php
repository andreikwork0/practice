@props(['name'])

@error($name)
<p class="alert alert-danger my-3">{{$message}}</p>
@enderror


